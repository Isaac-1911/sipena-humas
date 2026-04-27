<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArchiveStoreRequest;
use App\Http\Requests\ArchiveUpdateRequest;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Archive::latest()->paginate(10);

        return view('admin.archives.index', compact('archives'));
        // dd($archives);
    }

    public function create()
    {
        return view('admin.archives.create');
    }

    public function show(Archive $archive)
    {

        return view('admin.archives.show', compact('archive'));
    }

    public function store(ArchiveStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $folder = match ($data['category']) {
                'image' => 'archives/images',
                'video' => 'archives/videos',
                'document' => 'archives/documents'
            };

            $data['file_path'] = $request->file('file')->store($folder, 'public');
        }

        Archive::create($data);

        return redirect()->route('admin.archive.index')->with('success', 'Archive stored');
    }

    public function edit(Archive $archive)
    {
        return view('admin.archives.edit', compact('archive'));
    }

    public function update(ArchiveUpdateRequest $request, Archive $archive)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {

            if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
                Storage::disk('public')->delete($archive->file_path);
            }

            $folder = match ($data['category']) {
                'image' => 'archives/images',
                'video' => 'archives/videos',
                'document' => 'archives/documents',
            };

            $data['file_path'] = $request->file('file')->store($folder, 'public');
        }

        $archive->update($data);

        return redirect()->route('admin.archive.index')
            ->with('success', 'Archive updated successfully');
    }

    public function destroy(Archive $archive){
        if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)){
            Storage::disk('public')->delete($archive->file_path);
        }

        $archive->delete();

        return redirect()->route('admin.archive.index')->with('success', 'Archive deleted');
    }
}
