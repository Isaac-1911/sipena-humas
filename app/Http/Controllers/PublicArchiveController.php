<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class PublicArchiveController extends Controller
{
    public function index()
    {
        $archives = Archive::whereNotNull('file_path')
            ->latest()
            ->paginate(10);

        return view('public.archives.index', compact('archives'));
    }

    public function show(Archive $archive)
    {

        return view('public.archives.show', compact('archive'));
    }
}
