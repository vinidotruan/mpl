<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function store(Request $request): View
    {
        $book = Books::create($request->all());
        return view("welcome");
    }
}
