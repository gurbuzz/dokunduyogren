<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ApiPagesController extends Controller
{
    public function index($bookId)
    {
        $book = Book::findOrFail($bookId);
        $pages = $book->pages; // Belirli bir kitabın sayfalarını al
        return response()->json(['book' => $book, 'pages' => $pages], 200);
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
    
        // Dosyanın public/images dizinine taşınması
        $moved = $request->image_url->move(public_path('images'), $imageName);
        if (!$moved) {
            Log::error('Image not moved to public/images directory.');
            return response()->json(['error' => 'Resim yüklenemedi.'], 500);
        }
    
        Log::info('Image moved to: ' . public_path('images/' . $imageName));
    
        // Veritabanına sayfa kaydı
        $page = Page::create([
            'name' => $request->name,
            'image_url' => $imageName,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $request->book_id,
        ]);
    
        Log::info('Created Page ID: ' . $page->page_id);
    
        return response()->json(['message' => 'Sayfa başarıyla oluşturuldu.', 'page' => $page], 201);
    }
    

    public function show($id)
    {
        $page = Page::findOrFail($id);
        return response()->json($page, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'page_number' => 'required|integer',
            'book_id' => 'required|exists:books,id',
        ]);

        $page = Page::findOrFail($id);

        if ($request->hasFile('image_url')) {
            $request->validate([
                'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Resmi public/images dizinine taşı
            $imageName = time().'.'.$request->image_url->getClientOriginalExtension();
            $request->image_url->move(public_path('images'), $imageName);
            $page->image_url = $imageName;
        }

        // Sayfa bilgilerini güncelle
        $page->update([
            'name' => $request->name,
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $request->book_id,
        ]);

        return response()->json(['message' => 'Sayfa başarıyla güncellendi.', 'page' => $page], 200);
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return response()->json(['message' => 'Sayfa başarıyla silindi.'], 200);
    }

    public function storeQRCode(Request $request, $pageId)
    {
        try {
            // Dosya boyutu ve formatını kontrol eden validasyon
            $request->validate([
                'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'qr_image.max' => 'Yüklenen dosya boyutu 2MB\'ı aşmamalıdır.',
            ]);

            // Bellek limitini artırma
            ini_set('memory_limit', '256M');

            // Sayfayı veritabanından bul
            $page = Page::findOrFail($pageId);
            Log::info('Page found with ID: ' . $pageId);

            // QR kod resmini işle
            $qrImage = $request->file('qr_image');
            if (!$qrImage) {
                Log::error('QR code image not found in the request.');
                return response()->json(['error' => 'QR kodu resmi gereklidir.'], 422);
            }

            // Sayfa resmi yolu
            $pageImagePath = public_path('images/' . $page->image_url);
            if (!file_exists($pageImagePath)) {
                Log::error('Page image file does not exist at path: ' . $pageImagePath);
                return response()->json(['error' => 'Sayfa resmi bulunamadı.'], 500);
            }


            $manager = new ImageManager(new Driver());
            $pageImage = $manager->read($pageImagePath);
            $qrCode = $manager->read($qrImage->getPathname());
            $qrCode->resize(400, 400);

            // QR kodu sayfa resmine yerleştir
            $pageImage->place($qrCode, 'top-left', 50, 50);
            $pageImage->save($pageImagePath);

            Log::info('QR code successfully added to the page image.');

            return response()->json(['message' => 'QR kod başarıyla eklendi.', 'page' => $page], 200);
        } catch (\Exception $e) {
            Log::error('Error occurred in storeQRCode: ' . $e->getMessage());
            return response()->json(['error' => 'Bir hata oluştu. Lütfen tekrar deneyin.'], 500);
        }
    }
    
}
