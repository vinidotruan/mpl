<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function store(Request $request): View
    {
        $book = Books::create($request->all());
        return view("welcome");
    }

    public function upload(Request $request)
    {
        if($request->hasFile("file")) {
            $file = $request->file("file");
            $name = $file->getClientOriginalName();
            $nameCover = str_replace(".pdf", ".jpg", $name);
            $bookFile = Storage::putFileAs(Books::BOOKS_DIR, $file, $name, 'public');
            $pdf = new \Spatie\PdfToImage\Pdf($file);

            if (!Storage::exists(Books::COVERS_DIR)) {
                Storage::createDirectory(Books::COVERS_DIR);
            }
            $image = $pdf->saveImage(Storage::path(Books::COVERS_DIR."/".$nameCover));

            if($bookFile) {
                Books::create([
                    "file" => $name,
                    "cover" => $nameCover,
                    "name" => $request->get("name"),
                ]);
            }
        } else {
            return response()->json(["data" => "cara deu merda aqui"]);
        }

        return response()->json(["data" => "created", "image" => $image]);
    }
}
