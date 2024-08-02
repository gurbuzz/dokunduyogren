<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Page;
use Illuminate\Support\Facades\Log;

class TagsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tag = Tag::create($request->all());
        return response()->json($tag, 201);
    }

    public function index($page_id)
    {
        $tags = Tag::where('page_id', $page_id)->get();
        return response()->json($tags);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update($request->all());
        return response()->json($tag);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(null, 204);
    }

    public function create($page_id)
    {
        $page = Page::findOrFail($page_id);
        return view('tags.create', compact('page'));
    }

    public function storeTags(Request $request, $page_id)
    {
        $coordinates = json_decode($request->coordinates, true);

        foreach ($coordinates as $coord) {
            Tag::updateOrCreate(
                [
                    'page_id' => $page_id,
                    'position_x' => $coord['x'],
                    'position_y' => $coord['y'],
                    'width' => $coord['width'],
                    'height' => $coord['height']
                ],
                [
                    'label' => $coord['label'] ?? ''
                ]
            );
        }
        return response()->json(['message' => 'Etiketler başarıyla kaydedildi.'], 200);
    }


        public function showTags($pageId)
    {
        $page = Page::findOrFail($pageId);
        $tags = Tag::where('page_id', $pageId)->get();

        return view('tags.show_tags', compact('tags', 'page'));
    }
    public function showTranslateTags($pageId)
    {
        $page = Page::findOrFail($pageId);
        $tags = Tag::where('page_id', $pageId)->get();

        return view('tags.translate_tags', compact('tags', 'page'));
    }

    public function storeTranslateTags(Request $request, $pageId)
    {
        $translations = $request->input('tags');
        $language = $request->input('language');
    
        Log::info('Received translations', ['translations' => $translations]);
        Log::info('Language selected', ['language' => $language]);
    
        foreach ($translations as $tagId => $translatedLabel) {
            Log::info('Attempting to update tag', ['tag_id' => $tagId, 'translated_label' => $translatedLabel, 'translated_language' => $language]);
    
            if($tagId == 0) {
                Log::error('Tag ID is 0, check form submission.');
                continue;
            }
    
            $tag = Tag::findOrFail($tagId);
            Log::info('Before updating tag', ['tag_id' => $tagId, 'current_translated_label' => $tag->translated_label, 'current_translated_language' => $tag->translated_language]);
    
            $tag->translated_label = $translatedLabel;
            $tag->translated_language = $language;
            $tag->save();
    
            Log::info('After updating tag', ['tag_id' => $tagId, 'new_translated_label' => $translatedLabel, 'new_translated_language' => $language]);
        }
    
        return redirect()->route('books.pages.index', ['book' => Page::findOrFail($pageId)->book_id])
                         ->with('success', 'Etiketler başarıyla güncellendi.');
    }
    
    
}
