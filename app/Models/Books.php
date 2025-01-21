<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    const COVERS_DIR = "covers";
    const BOOKS_DIR = "books";
    protected $fillable = ["cover", "name", "file"];
}
