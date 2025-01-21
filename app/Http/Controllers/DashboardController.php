<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view("dashboard", ["books" => Books::all()]);
    }

    public function upload()
    {
        return view("dashboard");
    }
}
