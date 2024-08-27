<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Page;
use Illuminate\Support\Facades\Log;

class TagTranslationController extends Controller
{
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

        return redirect()->route('books.pages.index', ['book' => Page::findOrFail($pageId)->book_id])
                         ->with('success', 'Etiketler başarıyla güncellendi.');
    }
}
