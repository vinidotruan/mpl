<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books\UploadBookRequest;
use App\Services\GithubService;
use App\Models\Books;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function upload(UploadBookRequest $request, GithubService $service): JsonResponse
    {
        $checkout = $service->checkout();
        if($checkout !== 1) {
            return response()->json($checkout, 500);
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

            if($bookFile) {
                Books::create([
                    "file" => $name,
                    "cover" => $nameCover,
                    "name" => $request->get("name"),
                ]);
            }
        }

        $response = $service->commit("Adding ".$request->get("name"));
        if ($response !== 1) {
            return response()->json($response, 500);
        }

        return response()->json(["data" => "created", "image" => $image]);
    }
}
