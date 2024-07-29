<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Page;


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
        $coordinates = rtrim($request->coordinates, ';');
        $coordsArray = explode(';', $coordinates);

        foreach ($coordsArray as $coord) {
            list($x, $y, $width, $height) = explode(',', $coord);
            Tag::create([
                'page_id' => $page_id,
                'position_x' => $x,
                'position_y' => $y,
                'width' => $width,
                'height' => $height,
                'label' => ''
            ]);
        }

        return redirect()->route('pages.label_tags', ['page' => $page_id]);
    }

    public function label($page_id)
    {
        $tags = Tag::where('page_id', $page_id)->where('label', '')->get();
        return view('tags.label', compact('tags'));
    }

    public function labelStore(Request $request, $page_id)
    {
        foreach ($request->tags as $id => $description) {
            $tag = Tag::find($id);
            $tag->label = $description;
            $tag->save();
        }

        return redirect()->route('books.pages.index', ['book' => Page::find($page_id)->book_id])
            ->with('success', 'Etiketler başarıyla kaydedildi.');
    }
    
}
