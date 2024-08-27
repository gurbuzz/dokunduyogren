<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookCreationController extends Controller
{
    public function create()
    {
        return view('books.create_book');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'isbn' => 'required|string|max:13',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:255',
            'additional_info' => 'nullable|json',
        ]);

        $coverImageName = null;
        if ($request->hasFile('cover_image')) {
            $coverImageName = time().'.'.$request->cover_image->extension();  
            $request->cover_image->move(public_path('images'), $coverImageName);
        }

        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_date = $request->published_date;
        $book->isbn = $request->isbn;
        $book->cover_image = $coverImageName;
        $book->category = $request->category;
        $book->additional_info = json_decode($request->additional_info, true);
        $book->save();

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla oluşturuldu.');
    }
}
