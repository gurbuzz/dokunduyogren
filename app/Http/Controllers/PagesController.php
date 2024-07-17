<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Book;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index($bookId)
    {
        $book = Book::findOrFail($bookId);
        $pages = $book->pages; // Belirli bir kitabın sayfalarını al
        return view('dashboard', compact('pages', 'book'));
    }

    public function create()
    {
        $books = Book::all(); // Kitap listesini al
        return view('pages.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'page_number' => 'required|integer',
            'book_id' => 'required|exists:books,id', // Kitap ID'si doğrulaması
        ]);

        $imageName = time().'.'.$request->image_url->extension();  
        $request->image_url->move(public_path('images'), $imageName);

        $page = new Page;
        $page->name = $request->name;
        $page->category = $request->category;
        $page->tags = $request->tags;
        $page->image_url = $imageName;
        $page->content = $request->content;
        $page->page_number = $request->page_number;
        $page->book_id = $request->book_id; // Kitap ID'sini ekleyin
        $page->save();

        return redirect()->route('books.pages.index', $page->book_id)->with('success', 'Sayfa başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $books = Book::all(); // Kitap listesini al
        return view('pages.edit', compact('page', 'books'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'content' => 'required|string',
            'page_number' => 'required|integer',
            'book_id' => 'required|exists:books,id', // Kitap ID'si doğrulaması
        ]);

        $page = Page::findOrFail($id);
        if ($request->hasFile('image_url')) {
            $request->validate([
                'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $imageName = time().'.'.$request->image_url->extension();  
            $request->image_url->move(public_path('images'), $imageName);
            $page->image_url = $imageName;
        }

        $page->update([
            'name' => $request->name,
            'category' => $request->category,
            'tags' => $request->tags,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $request->book_id, // Kitap ID'sini güncelleyin
        ]);

        return redirect()->route('books.pages.index', $page->book_id)->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $bookId = $page->book_id;
        $page->delete();
        return redirect()->route('books.pages.index', $bookId)->with('success', 'Sayfa başarıyla silindi.');
    }

    public function createForBook($bookId)
    {
        return view('pages.create', compact('bookId'));
    }

    public function storeForBook(Request $request, $bookId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'page_number' => 'required|integer',
        ]);

        $imageName = time().'.'.$request->image_url->extension();  
        $request->image_url->move(public_path('images'), $imageName);

        $page = new Page;
        $page->book_id = $bookId; // Kitap ID'sini ekleyin
        $page->name = $request->name;
        $page->category = $request->category;
        $page->tags = $request->tags;
        $page->image_url = $imageName;
        $page->content = $request->content;
        $page->page_number = $request->page_number;
        $page->save();

        return redirect()->route('books.pages.index', $bookId)->with('success', 'Sayfa başarıyla oluşturuldu.');
    }
}
