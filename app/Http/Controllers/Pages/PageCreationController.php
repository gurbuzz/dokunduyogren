<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageCreationController extends Controller
{
    public function create($bookId)
    {
        $book = Book::findOrFail($bookId);
        return view('pages.create', compact('book'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'page_number' => 'required|integer',
            'book_id' => 'required|exists:books,id',
        ]);

        $imageName = time().'.'.$request->image_url->getClientOriginalExtension();  
        $request->image_url->storeAs('public/images', $imageName);

        $page = Page::create([
            'name' => $request->name,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $request->book_id,
        ]);

        Log::info('Created Page ID: ' . $page->page_id);

        return redirect()->route('pages.create.qrcode', ['page' => $page->page_id]);
    }

    public function createForBook($bookId)
    {
        $book = Book::findOrFail($bookId);
        return view('pages.create', compact('book'));
    }

    public function storeForBook(Request $request, $bookId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'page_number' => 'required|integer',
        ]);

        $imageName = time().'.'.$request->image_url->extension();  
        $request->image_url->move(public_path('images'), $imageName);

        $page = Page::create([
            'name' => $request->name,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $bookId,
        ]);

        Log::info('Created Page ID: ' . $page->page_id);

        return redirect()->route('pages.create.qrcode', ['page' => $page->page_id]);
    }
}
