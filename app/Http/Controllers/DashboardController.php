<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View | RedirectResponse
    {
        if(!Auth::user()) {
            return redirect('/auth/redirect');
        }
        return view("dashboard", ["books" => Books::all()]);
    }
}
