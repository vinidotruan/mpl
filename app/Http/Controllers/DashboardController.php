<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Title;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response {
        return Inertia::render("Dashboard", ["titles" => Title::all(), "books" => Books::with("title")->get()]);
    }

    public function filteredBooks(Request $request, Title $title): Response {
        $books = $title->books()->with("title")->get();
        return Inertia::render("Dashboard", ["titles" => Title::all(), "books" => $books ]);
    }

    public function titles(): JsonResponse
    {
        return response()->json(Title::all());
    }
}
