<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

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

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit_book', compact('book'));
    }

    public function update(Request $request, $id)
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

        $book = Book::findOrFail($id);
        if ($request->hasFile('cover_image')) {
            $coverImageName = time().'.'.$request->cover_image->extension();  
            $request->cover_image->move(public_path('images'), $coverImageName);
            $book->cover_image = $coverImageName;
        }

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'published_date' => $request->published_date,
            'isbn' => $request->isbn,
            'category' => $request->category,
            'additional_info' => json_decode($request->additional_info, true),
        ]);

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->route('books.index')->with('success', 'Kitap başarıyla silindi.');
    }
}
