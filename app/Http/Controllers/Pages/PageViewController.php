<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Book;

class PageViewController extends Controller
{
    public function index($bookId)
    {
        $book = Book::findOrFail($bookId);
        $pages = $book->pages;
        return view('pages.page_overview', compact('pages', 'book'));
    }
}
