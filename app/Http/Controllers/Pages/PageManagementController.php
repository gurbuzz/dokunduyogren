<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageManagementController extends Controller
{
    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'page_number' => 'required|integer',
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
            'content' => $request->content,
            'page_number' => $request->page_number,
            'book_id' => $page->book_id, // Mevcut `book_id` değerini kullanın.
        ]);

        return redirect()->route('books.pages.index', $page->book_id)
            ->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy(Page $page)
    {
        $bookId = $page->book_id;
        $page->delete();

        return redirect()->route('books.pages.index', $bookId)
            ->with('success', 'Sayfa başarıyla silindi.');
    }
}

