<?php

namespace App\Http\Controllers\Student;

use App\Exports\StudentsDormitoryExport;
use App\Exports\StudentsExport;
use App\Exports\StudentsRentsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Dormitory;
use App\Models\Forget;
use App\Models\Rent;
use App\Models\StudentPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $download = request('download');
        $count = request('count') ?? 10;
        if ($count == 'all') {
            $count = Student::whereHas('dormitory')->count();
        } else {
            $count = request('count');
        }
        $search = request('search');
        if ($search) {
            $students = Student::query();
            $students->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%$search%")
                    ->orWhere('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('faculty', 'like', "%$search%")
                    ->orWhere('group', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('coach', 'like', "%$search%");
            });
            $students = $students->paginate($count);

            if ($download) {
                return Excel::download(new StudentsExport($students), 'Barcha_talabalar.xlsx');
            }
        } else {
            $students = Student::paginate($count);
        }

        return view('students.index', compact('students'));
    }

    public function dormitory()
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $count = request('count') ?? 10;
        if ($count == 'all') {
            $count = Student::whereHas('dormitory')->count();
        } else {
            $count = request('count');
        }
        $students = Student::whereHas('dormitory')
            ->with('dormitory')
            ->paginate($count);

        return view('students.dormitory', compact('students'));
    }

    public function rent()
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }


        $count = request('count', 10);
        $type = request('type');

        if ($count == 'all') {
            $query = Student::whereHas('rent');

            if ($type) {
                $query->whereHas('rent', function ($q) use ($type) {
                    $q->where('type', $type);
                });
            }

            $count = $query->count();
        }

        $students = Student::whereHas('rent', function ($q) use ($type) {
            if ($type) {
                $q->where('type', $type);
            }
        })
            ->with('rent')
            ->paginate($count);


        return view('students.rent', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'faculty' => 'required|string',
            'group' => 'required|string',
            'living_type' => 'required|in:dormitory,rent',
        ]);

        // Student ma'lumotlarini saqlash
        $student = Student::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'faculty' => $request->faculty,
            'group' => $request->group,
            'phone' => $request->phone,
            'coach' => $request->coach,
            'father' => $request->father,
            'mather' => $request->mather,
            'province' => $request->province,
            'region' => $request->region,
            'address' => $request->address,
            'map_home' => $request->map_home,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'father_phone' => $request->father_phone,
            'mather_phone' => $request->mather_phone,
        ]);

        // Yashash turi bo'yicha ma'lumot saqlash
        if ($request->living_type === 'dormitory') {
            Dormitory::create([
                'student_id' => $student->student_id,
                'dormitory' => $request->dormitory,
                'room' => $request->room,
                'privileged' => $request->privileged ?? 0,
                'amount' => $request->dorm_amount ?? 0,
            ]);
        } elseif ($request->living_type === 'rent') {
            Rent::create([
                'student_id' => $student->student_id,
                'province' => $request->rent_province,
                'region' => $request->rent_region,
                'address' => $request->rent_address,
                'map_rent' => $request->map_rent,
                'latitude' => $request->rent_latitude,
                'longitude' => $request->rent_longitude,
                'type' => $request->rent_type,
                'owner_name' => $request->owner_name,
                'owner_phone' => $request->owner_phone,
                'category' => $request->category,
                'contract' => $request->contract ?? 0,
                'amount' => $request->rent_amount ?? 0,
            ]);
        }


        return redirect()->route('students.show', $student->id)->with('success', 'Student muvaffaqiyatli yaratildi!');
    }

    public function show($id)
    {
        $student = Student::with(['dormitory', 'rent'])->findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::with(['dormitory', 'rent'])->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'student_id' => 'sometimes|required|integer|unique:students,student_id,' . $student->id,
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'faculty' => 'sometimes|required|string',
            'group' => 'sometimes|required|string',
            'living_type' => 'sometimes|required|in:dormitory,rent',
        ]);
        // Eski yashash ma'lumotlarini o'chirish
        if ($student->dormitory) {
            $student->dormitory->delete();
        }
        if ($student->rent) {
            $student->rent->delete();
        }
        // Student ma'lumotlarini yangilash
        $student->update([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'faculty' => $request->faculty,
            'group' => $request->group,
            'phone' => $request->phone,
            'coach' => $request->coach,
            'father' => $request->father,
            'mather' => $request->mather,
            'province' => $request->province,
            'region' => $request->region,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'father_phone' => $request->father_phone,
            'mather_phone' => $request->mather_phone,
        ]);

        // Yangi yashash turi bo'yicha ma'lumot saqlash
        if ($request->living_type === 'dormitory') {
            Dormitory::create([
                'student_id' => $student->student_id,
                'dormitory' => $request->dormitory,
                'room' => $request->room,
                'privileged' => $request->privileged ?? 0,
                'amount' => $request->dorm_amount ?? 0,
            ]);
        } elseif ($request->living_type === 'rent') {
            Rent::create([
                'student_id' => $student->student_id,
                'province' => $request->rent_province,
                'region' => $request->rent_region,
                'address' => $request->rent_address,
                'latitude' => $request->rent_latitude,
                'longitude' => $request->rent_longitude,
                'type' => $request->rent_type,
                'owner_name' => $request->owner_name,
                'owner_phone' => $request->owner_phone,
                'category' => $request->category,
                'contract' => $request->contract ?? 0,
                'amount' => $request->rent_amount ?? 0,
            ]);
        }

        return redirect()->route('students.show', $student->id)->with('success', 'Student muvaffaqiyatli yangilandi!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student o‘chirildi!');
    }




    public function login()
    {
        return view('students.login');
    }

    public function logout(Request $request, $id)
    {
        $request->session()->forget('student_id');
        return redirect()->route('students.login')->with('success', 'Siz tizimdan chiqdingiz.');
    }

    public function check(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'password' => 'nullable|string',
        ]);


        $student = Student::where('student_id', $request->student_id)->first();

        if (!$student) {
            return redirect()->route('students.login')->with('error', 'Talaba topilmadi.');
        }

        if ($request->filled('password')) {
            // Talabaning paroli bormi?
            if (!$student->student_password) {
                return redirect()->route('students.login')->with('error', 'Sizda parol o\'rnatilmagan.');
            }

            // Parolni tekshirish
            if (Hash::check($request->password, $student->student_password->password)) {
                session(['student_id' => $request->student_id]);
                return redirect()->route('students.show', $student->id)->with('success', 'Xush kelibsiz!');
            } else {
                return redirect()->route('students.login')->with('error', 'Noto\'g\'ri parol kiritildi.');
            }
        }

        // Agar parol kiritilmagan bo'lsa
        // Talabada parol bormi tekshirish
        if ($student->student_password) {
            // Parol so'rash sahifasini ko'rsatish
            return view('students.login', [
                'get_password' => true,
                'student_id' => $request->student_id
            ]);
        }

        // Parol yo'q bo'lsa to'g'ridan-to'g'ri kirish
        session(['student_id' => $request->student_id]);
        return redirect()->route('students.show', $student->id)->with('success', 'Xush kelibsiz!');
    }

    public function newPassword(Request $request, string $id)
    {
        $student = Student::find($id);
        if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')) {
            $request->validate([
                'password' => 'required|string|confirmed'
            ]);

            if ($student->student_password) {
                $student->student_password->update([
                    'password' => Hash::make(request('password')),
                ]);
            } else {
                StudentPassword::create([
                    'student_id' => $student->student_id,
                    'password' => Hash::make(request('password')),
                ]);
            }
            if ($student->forget && $student->forget->status == 0) {
                $student->forget->update([
                    'status' => 1
                ]);
            }


            return redirect()->route('students.show', $student->id)->with('success', 'Parol muvaffaqiyatli o\'zgartirildi!');
        } elseif ($student->student_password) {
            $request->validate([
                'old_password' => 'required|string',
                'password' => 'required|string|confirmed'
            ]);

            if ($student && Hash::check(request('old_password'), $student->student_password->password)) {
                $student->student_password->update([
                    'password' => Hash::make(request('password')),
                ]);
                if ($student->forget) {
                    $student->forget->update([
                        'status' => 1
                    ]);
                }
                return redirect()->route('students.show', $student->id)->with('success', 'Parol muvaffaqiyatli o\'zgartirildi!');
            } else {
                return back();
            }
        } else {
            $request->validate([
                'password' => 'required|string|confirmed',
            ]);

            StudentPassword::create([
                'student_id' => $student->student_id,
                'password' => Hash::make(request('password')),
            ]);

            if ($student->forget) {
                $student->forget->update([
                    'status' => 1
                ]);
            }

            return redirect()->route('students.show', $student->id)->with('success', 'Parol muvaffaqiyatli o\'rnatildi!');
        }
    }

    public function forget()
    {
        return view('students.forget');
    }
    public function forgets()
    {
        $students = Forget::with('student')->get();
        return view('students.forgets', compact('students'));
    }
    public function send(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'messeng' => 'required|string'
        ]);

        $student = Student::where('student_id', request('student_id'))->first();
        if ($student) {
            $forget = Forget::where('student_id', request('student_id'))->first();
            if ($forget && $forget->status == 0) {
                return redirect()->route('students.login')->with('error', 'Siz allaqachon xabar yuborgansiz, iltimos kuting.');
            }
            Forget::create([
                'student_id' => request('student_id'),
                'messeng' => request('messeng'),
            ]);
            return redirect()->route('students.login')->with('success', 'Xabar yuborildi')->with('send', true);
        }
        return redirect()->route('students.login')->with('error', 'Siz tizimda mavjud emassiz');
    }

    public function exportStudentsDormitory()
    {
        return Excel::download(new StudentsDormitoryExport(), 'Yotoqxona_talabalari.xlsx');
    }

    public function exportStudentsRents()
    {
        return Excel::download(new StudentsRentsExport, 'Ijara_talabalari.xlsx');
    }
}
