<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiTagsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,page_id',
            'label_info' => 'nullable|json',
            'position' => 'required|json',
            'shape_type' => 'nullable|string|max:255',
        ]);

        $tag = Tag::create([
            'page_id' => $request->page_id,
            'label_info' => json_decode($request->label_info, true),
            'position' => json_decode($request->position, true),
            'shape_type' => $request->shape_type,
        ]);

        return response()->json($tag, 201);
    }

    public function index($page_id)
    {
        $tags = Tag::where('page_id', $page_id)->get();
        return response()->json($tags, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'label_info' => 'nullable|json',
            'position' => 'required|json',
            'shape_type' => 'nullable|string|max:255',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update([
            'label_info' => json_decode($request->label_info, true),
            'position' => json_decode($request->position, true),
            'shape_type' => $request->shape_type,
        ]);

        return response()->json($tag, 200);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(null, 204);
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

    public function storeTranslateTags(Request $request, $pageId)
    {
        $translations = $request->input('tags');
        $language = $request->input('language');

        Log::info('Received translations', ['translations' => $translations]);
        Log::info('Language selected', ['language' => $language]);

        foreach ($translations as $tagId => $translatedLabel) {
            Log::info('Attempting to update tag', ['tag_id' => $tagId, 'translated_label' => $translatedLabel, 'translated_language' => $language]);

            if ($tagId == 0) {
                Log::error('Tag ID is 0, check form submission.');
                continue;
            }

            $tag = Tag::findOrFail($tagId);
            Log::info('Before updating tag', ['tag_id' => $tagId, 'current_label_info' => $tag->label_info]);

            $labelInfo = $tag->label_info;
            $labelInfo['translated_label'] = $translatedLabel;
            $labelInfo['translated_language'] = $language;
            $tag->label_info = $labelInfo;
            $tag->save();

            Log::info('After updating tag', ['tag_id' => $tagId, 'new_label_info' => $tag->label_info]);
        }

        return response()->json(['message' => 'Etiketler başarıyla güncellendi.'], 200);
    }
}
