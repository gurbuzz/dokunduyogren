<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string',
        ]);

        $page = Page::create($request->all());
        return response()->json($page, 201);
    }

    public function show($id)
    {
        $page = Page::findOrFail($id);
        return response()->json($page);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $page = Page::findOrFail($id);
        $page->update($request->all());
        return response()->json($page);
    }

    public function destroy($id)
    {
        Page::destroy($id);
        return response()->json(null, 204);
    }
}
