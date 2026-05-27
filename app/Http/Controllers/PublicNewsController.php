<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
            ->latest()
            ->paginate(9);

        $featuredNews = News::where('is_published', true)
            ->latest()
            ->first();

        return view('public.news.index', compact(
            'news',
            'featuredNews'
        ));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.news.show', compact(
            'news',
            'relatedNews'
        ));
    }
}
