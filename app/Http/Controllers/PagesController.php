<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Book;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PagesController extends Controller
{
    public function index($bookId)
    {
        $book = Book::findOrFail($bookId);
        $pages = $book->pages; // Belirli bir kitabın sayfalarını al
        return view('pages.page_overview', compact('pages', 'book'));
    }

    public function create($bookId)
    {
        $book = Book::findOrFail($bookId);
        return view('pages.create', compact('book'));
    }
    
    

    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
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
            'book_id' => 'required|exists:books,id',
        ]);

        $imageName = time().'.'.$request->image_url->getClientOriginalExtension();  
        $request->image_url->storeAs('public/images', $imageName);

        $page = Page::create([
            'name' => $request->name,
            'category' => $request->category,
            'tags' => $request->tags,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $request->book_id,
        ]);

        Log::info('Created Page ID: ' . $page->page_id);

        return redirect()->route('pages.create.qrcode', ['page' => $page->page_id]);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'content' => 'required|string',
            'page_number' => 'required|integer',
            'book_id' => 'required|exists:books,id',
        ]);

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
            'book_id' => $request->book_id,
        ]);

        return redirect()->route('books.pages.index', $page->book_id)->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy(Page $page)
    {
        $bookId = $page->book_id;
        $page->delete();
        return redirect()->route('books.pages.index', $bookId)->with('success', 'Sayfa başarıyla silindi.');
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
            'category' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'page_number' => 'required|integer',
        ]);

        $imageName = time().'.'.$request->image_url->extension();  
        $request->image_url->move(public_path('images'), $imageName);

        $page = Page::create([
            'name' => $request->name,
            'category' => $request->category,
            'tags' => $request->tags,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $bookId,
        ]);

        Log::info('Created Page ID: ' . $page->page_id);

        return redirect()->route('pages.create.qrcode', ['page' => $page->page_id]);
    }

    public function createQRCode($pageId)
    {
        $page = Page::findOrFail($pageId);
        $tags = Tag::where('page_id', $pageId)->get();
        return view('pages.create_qrcode', compact('page', 'tags'));
    }
    
    public function storeQRCode(Request $request, Page $page)
    {
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // QR kod resmini işle
        $qrImage = $request->file('qr_image');
        if (!$qrImage) {
            return back()->withErrors('QR kodu resmi gereklidir.');
        }

        // Resim ve QR kodunu işle
        $pageImagePath = public_path('images/' . $page->image_url);

        // Intervention Image v3 kullanımı
        $manager = new ImageManager(new Driver());
        $pageImage = $manager->read($pageImagePath);
        $qrCode = $manager->read($qrImage->getPathname());
        $qrCode->resize(400, 400); 

        $pageImage->place($qrCode, 'top-left', 50, 50);
        $pageImage->save($pageImagePath); // Güncellenmiş resmi kaydet

        return redirect()->route('pages.add_tags', ['page' => $page->page_id])
            ->with('success', 'Sayfa başarıyla oluşturuldu ve QR kod eklendi.');
    }

}
