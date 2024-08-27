<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Page;

class TagViewController extends Controller
{
    public function index($page_id)
    {
        $tags = Tag::where('page_id', $page_id)->get();
        return response()->json($tags);
    }

    public function showTags($pageId)
    {
        $page = Page::findOrFail($pageId);
        $tags = Tag::where('page_id', $pageId)->get();

        return view('tags.show_tags', compact('tags', 'page'));
    }
}
