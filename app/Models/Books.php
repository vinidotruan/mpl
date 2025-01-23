<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Books extends Model
{
    const COVERS_DIR = "covers";
    const BOOKS_DIR = "books";
    protected $fillable = ["cover", "name", "file", "title_id"];
    protected $appends = ["url", "curl"];

    public function title(): BelongsTo
    {
        return $this->belongsTo(Title::class);
    }

    public function url(): Attribute
    {
        return Attribute::get(fn() => asset('storage/books/'.$this->file));
    }

    public function curl(): Attribute
    {
        return Attribute::get(fn() => asset('storage/covers/'.$this->cover));
    }
}
