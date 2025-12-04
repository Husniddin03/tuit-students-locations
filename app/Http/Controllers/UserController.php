<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $count = request('count') ?? 10;

        $users = User::paginate($count);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:admin,super_admin'
        ]);

        User::create($data);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::user()->role !== 'super_admin' && Auth::user()->id != $id) {
            return back();
        }
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'password' => 'sometimes|required|string|confirmed',
            'role' => 'sometimes|required|in:admin,super_admin'
        ]);

        $user = User::find($id);
        $user->update($data);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->role !== 'super_admin') {
            return back();
        }
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
