<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Tag;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PageQRCodeController extends Controller
{
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
        ], [
            'qr_image.max' => 'Yüklenen dosya boyutu 2MB\'ı aşmamalıdır.',
        ]);

        ini_set('memory_limit', '256M');

        $qrImage = $request->file('qr_image');
        if (!$qrImage) {
            return back()->withErrors('QR kodu resmi gereklidir.');
        }

        $pageImagePath = public_path('images/' . $page->image_url);

        $manager = new ImageManager(new Driver());
        $pageImage = $manager->read($pageImagePath);
        $qrCode = $manager->read($qrImage->getPathname());
        $qrCode->resize(400, 400);

        $pageImage->place($qrCode, 'top-left', 50, 50);
        $pageImage->save($pageImagePath);

        return redirect()->route('pages.add_tags', ['page' => $page->page_id])
            ->with('success', 'Sayfa başarıyla oluşturuldu ve QR kod eklendi.');
    }
}
