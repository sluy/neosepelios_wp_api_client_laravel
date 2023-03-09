<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function home()
    {
        if(auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('welcome');
    }

    public function createInstance()
    {
        return view('create');
    }

    public function instance($id)
    {
        $instance = Auth::user()->instances()->findOrFail($id);
        
        return view('instance', [
            'instance' => $instance
        ]);
    }
}
