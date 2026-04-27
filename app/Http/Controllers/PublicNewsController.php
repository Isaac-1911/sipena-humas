<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index()
    {

        $news = News::where('is_published', true)->paginate(10);


        return view('public.news.index', compact('news'));
        // dd($news);

    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.news.show', compact('news'));
    }
}
