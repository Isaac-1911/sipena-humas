<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $featuredNews = News::latest()->first();

        $sideNews = News::latest()->skip(1)->take(3)->get();

        return view('public.home', compact('featuredNews', 'sideNews'));

    }
}
