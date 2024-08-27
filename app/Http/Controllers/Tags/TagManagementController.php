<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagManagementController extends Controller
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

        return response()->json($tag);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(null, 204);
    }
}
