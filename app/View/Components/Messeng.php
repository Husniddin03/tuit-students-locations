<?php

namespace App\View\Components;

use App\Models\Dormitory;
use App\Models\Forget;
use App\Models\Rent;
use App\Models\Student;
use Illuminate\View\Component;

class Messeng extends Component
{

    public $messengs;

    public function __construct()
    {
        $this->messengs = Forget::where('status', 0)->get();
    }

    public function render()
    {
        return view('components.dropdown-notifications');
    }
}
