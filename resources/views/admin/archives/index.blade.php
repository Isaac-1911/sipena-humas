@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Arsip</h1>
        <p class="text-gray-500">{{ $archives->total() }} file tersimpan</p>
    </div>

    <button onclick="openModal()"
        class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
        + Unggah Arsip
    </button>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-3 gap-6">

    @forelse($archives as $archive)
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="h-40 bg-gray-200 flex items-center justify-center">
                @if($archive->category === 'image')
                    <img src="{{ asset('storage/' . $archive->file_path) }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-gray-500 text-sm uppercase">
                        {{ $archive->category }}
                    </span>
                @endif
            </div>

            <div class="p-4">

                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs bg-gray-200 px-2 py-1 rounded capitalize">
                        {{ $archive->category }}
                    </span>

                    <span class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($archive->created_at)->format('Y-m-d') }}
                    </span>
                </div>

                <h2 class="font-semibold mb-3">
                    {{ $archive->title }}
                </h2>

                <div class="flex justify-between items-center">

                    <a href="{{ asset('storage/' . $archive->file_path) }}"
                       target="_blank"
                       class="text-blue-600 text-sm">
                        Lihat
                    </a>

                    <div class="space-x-2 text-sm">
                        <a href="{{ route('admin.archive.edit', $archive->id) }}"
                           class="text-yellow-600">
                            Edit
                        </a>

                        <form action="{{ route('admin.archive.destroy', $archive->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Yakin hapus?')"
                                    class="text-red-600">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>

    @empty
        <p class="col-span-3 text-center text-gray-500">
            Tidak ada data arsip
        </p>
    @endforelse

</div>

<div class="mt-6">
    {{ $archives->links() }}
</div>

{{-- MODAL --}}
<div id="archiveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-xl p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Unggah Arsip Baru</h2>
            <button onclick="closeModal()">✕</button>
        </div>

        <form action="{{ route('admin.archive.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-2">File</label>
                <input type="file" name="file" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-2">Judul</label>
                <input type="text" name="title" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-2">Kategori</label>
                <select name="category" class="w-full border p-2 rounded">
                    <option value="">Pilih kategori</option>
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                    <option value="document">Document</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Deskripsi</label>
                <textarea name="description" class="w-full border p-2 rounded"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border rounded">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-blue-900 text-white rounded">
                    Unggah
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function openModal() {
    document.getElementById('archiveModal').classList.remove('hidden');
    document.getElementById('archiveModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('archiveModal').classList.add('hidden');
}
</script>

@endsection
