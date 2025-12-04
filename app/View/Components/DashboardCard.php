<?php

namespace App\View\Components;

use App\Models\Dormitory;
use App\Models\Rent;
use App\Models\Student;
use Illuminate\View\Component;

class DashboardCard extends Component
{
    public $students;
    public $cardNumber;
    public $dormitory;
    public $rent;

    public function __construct($cardNumber)
    {
        $this->rent = Rent::with('student')->get();
        $count = request('count') ?? 10;
        if ($count == 'all') {
            $count = Student::count();
        } else {
            $count = request('count');
        }
        $this->students = Student::with(['dormitory', 'rent'])->paginate($count);
        $this->cardNumber = $cardNumber;
    }

    public function render()
    {
        return view('components.dashboard.dashboard-card-' . $this->cardNumber);
    }
}
