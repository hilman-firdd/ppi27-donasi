@extends('layouts.app', ['title' => 'Edit Campaign - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">

        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold capitalize">EDIT CAMPAIGN</h2>
            <hr class="mt-4">
            <form action="{{ route('admin.campaign.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 mt-4">
                    <div>
                        <label class="text-gray-700" for="image">GAMBAR</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white p-3" type="file" name="image">
                    </div>

                    <div>
                        <label class="text-gray-700" for="name">JUDUL CAMPAIGN</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="title" value="{{ old('title', $campaign->title) }}" placeholder="Judul Campaign">
                        @error('title')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="name">KATEGORI</label>
                        <select class="w-full border bg-gray-200 focus:bg-white rounded px-3 py-2 outline-none" name="category_id">
                            @foreach($categories as $category)
                                <option class="py-1" value="{{ $category->id }}" @if($campaign->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                          </select>
                        @error('category_id')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="name">DESKRIPSI</label>
                        <textarea name="description" rows="5">{{ old('description', $campaign->description) }}</textarea>
                        @error('description')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="name">TARGET DONASI</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white p-3" type="number" name="target_donation" value="{{ old('target_donation', $campaign->target_donation) }}" placeholder="Target Donasi, Ex: 10000000">
                        @error('target_donation')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="name">TANGGAL BERAKHIR</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white p-3" type="date" name="max_date" value="{{ old('max_date', $campaign->max_date) }}">
                        @error('max_date')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-start mt-4">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">UPDATE</button>
                </div>
            </form>
        </div>
        
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js"></script>
<script>
    tinymce.init({selector:'textarea'});
</script>
@endsection