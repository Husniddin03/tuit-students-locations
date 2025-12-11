<?php

namespace App\View\Components;

use App\Models\Rent;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public string $alertType = '';
    public ?string $alertMessage = null;

    public function __construct()
    {
        if(session()->has('success')) {
            $this->alertType = 'success';
            $this->alertMessage = session('success');
            session()->forget('success');
        } elseif(session()->has('error')) {
            $this->alertType = 'error';
            $this->alertMessage = session('error');
            session()->forget('error');
        } elseif(session()->has('info')) {
            $this->alertType = 'info';
            $this->alertMessage = session('info');
            session()->forget('info');
        }
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
