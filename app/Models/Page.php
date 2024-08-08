<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $primaryKey = 'page_id';

    protected $fillable = [
        'book_id', 'name', 'image_url', 'content', 'page_number', 'metadata'
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
