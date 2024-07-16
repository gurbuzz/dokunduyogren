<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('dashboard', compact('pages'));
    }

    public function create()
    {
        return view('pages.create');
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
        ]);

        $imageName = time().'.'.$request->image_url->extension();  
        $request->image_url->move(public_path('images'), $imageName);

        $page = new Page;
        $page->name = $request->name;
        $page->category = $request->category;
        $page->tags = $request->tags;
        $page->image_url = $imageName;
        $page->content = $request->content;
        $page->page_number = $request->page_number;
        $page->save();

        return redirect()->route('dashboard')->with('success', 'Sayfa başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'content' => 'required|string',
            'page_number' => 'required|integer',
        ]);

        $page = Page::findOrFail($id);
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
        ]);

        return redirect()->route('dashboard')->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        Page::destroy($id);
        return redirect()->route('dashboard')->with('success', 'Sayfa başarıyla silindi.');
    }
}
