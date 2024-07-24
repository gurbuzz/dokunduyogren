<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Book;
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

    public function create()
    {
        $books = Book::all(); // Kitap listesini al
        return view('pages.create', compact('books'));
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

        $pageData = [
            'name' => $request->name,
            'category' => $request->category,
            'tags' => $request->tags,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $request->book_id
        ];

        // Form verilerini URL üzerinden yönlendirmek
        return redirect()->route('pages.create.qrcode', $pageData);
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

        $pageData = [
            'name' => $request->name,
            'category' => $request->category,
            'tags' => $request->tags,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $bookId
        ];

        return redirect()->route('pages.create.qrcode', $pageData);
    }


    public function createQRCode(Request $request)
    {
        $pageData = $request->all(); // Tüm URL parametrelerini al
    
        if (empty($pageData)) {
            Log::error('URL parameters are missing');
            return back()->withErrors('Gerekli bilgiler bulunamadı. Lütfen tekrar deneyiniz.');
        }
        
        return view('pages.create_qrcode', compact('pageData'));
    }
    


    public function storeQRCode(Request $request)
    {
        $pageData = $request->all();

        // QR kod resmini işle
        $qrImage = $request->file('qr_image');
        if (!$qrImage) {
            return back()->withErrors('QR kodu resmi gereklidir.');
        }

        // Resim ve QR kodunu işle
        $pageImagePath = public_path('images/' . $pageData['image_url']);

        // Intervention Image v3 kullanımı
        $manager = new ImageManager(new Driver());
        $pageImage = $manager->read($pageImagePath);
        $qrCode = $manager->read($qrImage->getPathname())->resize(400,400);

        $pageImage->place($qrCode, 'top-left', 50, 50);
        $pageImage->save($pageImagePath); // Güncellenmiş resmi kaydet

        // Veritabanı kaydı
        $page = new Page($pageData);
        $page->save();

        return redirect()->route('books.pages.index', ['book' => $page->book_id])
            ->with('success', 'Sayfa başarıyla oluşturuldu ve QR kod eklendi.');
    }
    
    
}
