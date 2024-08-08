<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'author', 'published_date', 'isbn', 'cover_image', 'category', 'additional_info'
    ];

    protected $casts = [
        'additional_info' => 'json',
    ];

    public function pages()
    {
        return $this->hasMany(Page::class, 'book_id', 'id');
    }
}
