@extends('layouts.app', ['title' => 'Donation - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">
        
        <form action="{{ route('admin.donation.filter') }}" method="GET">
            <div class="flex gap-6">

                <div class="flex-auto">
                    <label class="text-gray-700" for="name">TANGGAL AWAL</label>
                    <input class="form-input w-full mt-2 rounded-md bg-white p-3 shadow-md" type="date" name="date_from"
                        value="{{ old('date_form') ?? request()->query('date_from') }}">
                    @error('date_from')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror    
                </div>

                <div class="flex-auto">
                    <label class="text-gray-700" for="name">TANGGAL AKHIR</label>
                    <input class="form-input w-full mt-2 rounded-md bg-white p-3 shadow-md" type="date" name="date_to"
                        value="{{ old('date_to') ?? request()->query('date_to') }}">
                    @error('date_to')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror    
                </div>

                <div class="flex-1">
                    <button type="submit"
                        class="mt-8 w-full p-3 bg-gray-600 text-gray-200 rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">FILTER</button>
                </div>

            </div>
        </form>


        @if($donations ?? '')

            @if(count($donations) > 0)

                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow-sm rounded-lg overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class="justify-between">
                                <tr class="bg-gray-600 w-full">
                                    <th class="px-16 py-2">
                                        <span class="text-white">NAMA DONATUR</span>
                                    </th>
                                    <th class="px-16 py-2 text-left">
                                        <span class="text-white">CAMPAIGN</span>
                                    </th>
                                    <th class="px-16 py-2 text-left">
                                        <span class="text-white">TANGGAL</span>
                                    </th>
                                    <th class="px-16 py-2 text-center">
                                        <span class="text-white">JUMLAH DONASI</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-200">
                                @forelse($donations as $donation)
                                    <tr class="border bg-white">
                
                                        <td class="px-16 py-2 flex justify-center">
                                            {{ $donation->donatur->name }}
                                        </td>
                                        <td class="px-16 py-2">
                                            {{ $donation->campaign->title }}
                                        </td>
                                        <td class="px-16 py-2">
                                            {{ $donation->created_at }}
                                        </td>
                                        <td class="px-5 py-2 text-right">
                                            {{ moneyFormat($donation->amount) }}
                                        </td>
                                    </tr>
                                @empty
                                    <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                        Data Belum Tersedia!
                                    </div>
                                @endforelse
                                <tr class="border bg-gray-600 text-white font-bold">
                                    <td colspan="3" class="px-5 py-2 justify-center">
                                        TOTAL DONASI
                                    </td>
                                    <td colspan="3" class="px-5 py-2 text-right">
                                        {{ moneyFormat($total) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 

            @endif

        @endif

    </div>

</main>
@endsection