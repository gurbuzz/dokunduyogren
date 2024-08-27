<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Page;

class TagCreationController extends Controller
{
    public function create($page_id)
    {
        $page = Page::findOrFail($page_id);
        return view('tags.create', compact('page'));
    }

    public function storeTags(Request $request, $page_id)
    {
        $coordinates = json_decode($request->coordinates, true);

        foreach ($coordinates as $coord) {
            Tag::create([
                'page_id' => $page_id,
                'position' => [
                    'x' => $coord['x'],
                    'y' => $coord['y'],
                    'width' => $coord['width'],
                    'height' => $coord['height'],
                    'radius' => $coord['radius'] ?? null, // Circle için
                    'points' => $coord['points'] ?? null // Polygon için
                ],
                'label_info' => [
                    'label' => $coord['label'] ?? ''
                ],
                'shape_type' => $coord['shape_type'] ?? ''
            ]);
        }

        return response()->json(['message' => 'Etiketler başarıyla kaydedildi.'], 200);
    }
}
