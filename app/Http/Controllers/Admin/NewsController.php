<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $news = News::latest()->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $request->validated();


        $data = $request->only(['title', 'content']);
        $data['slug'] = News::generateUniqueSlug($request->title);

        $data['author_id'] = auth()->id();

        if ($request->hasFile('image')){
            $data['thumbnail'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {

        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {

        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNewsRequest $request, News $news)
    {
        $request->validated();

        $data = $request->only(['title', 'content']);

        if ($request->title !== $news->title){
            $data['slug'] = News::generateUniqueSlug($request->title);
        }

        if ($request->hasFile('image')){

            if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)){
                Storage::disk('public')->delete($news->thumbnail);
            }

            $data['thumbnail'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)){
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted!');
    }
}
