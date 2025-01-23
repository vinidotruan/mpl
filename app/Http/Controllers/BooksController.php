<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books\UploadBookRequest;
use App\Models\Books;
use App\Models\Title;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function upload(UploadBookRequest $request): JsonResponse
    {
        if($request->get('password') !== env("UPLOAD_PASSWORD")) {
            return response()->json(['data' => '😉', "a" => $request->get('uploadPassword'), "b" => env("UPLOAD_PASSWORD")], 403);
        }

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

            $titleData = $request->get('title');
            $title = Title::where("id", $titleData)->orWhere("name", $titleData)->first();
            if(!$title) {
                $title = Title::create([ "name" => $titleData ])->id;
            } else {
                $title = $title->id;
            }

            $book = Books::create([
                "file" => $name,
                "cover" => $nameCover,
                "name" => $request->get("name"),
                "title_id" => $title
            ]);
        }

        return response()->json(["data" => ["book" => $book->load('title')]]);
    }
}
