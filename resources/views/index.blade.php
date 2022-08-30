<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check Ongkir | KerelKA</title>
    <link rel="shortcut icon" href="{{ asset('icons/Icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <div class="w-full bg-[#202020] flex flex-col justify-center items-center pb-10">
            <div class="w-11/12 md:w-4/6 flex flex-col md:flex-row justify-between items-center">
                <div id="logo" class="h-10 md:h-16 p-1 md:p-0">
                    <a href="/">
                        <img src="{{ asset('icons/brand-icon.png') }}" alt="logo" class="h-full">
                    </a>
                </div>
                <div id="menu" class="flex justify-center items-center gap-5 text-red-600">
                    <a href="https://kerelka.com/blogs" class="hover:text-red-800">Blogs</a>
                    <a href="https://kerelka.com/aboutme" class="hover:text-red-800">About Me</a>
                </div>
            </div>
            <div class="w-11/12 md:w-4/6 flex justify-center items-center py-10">
                <h1 class="text-gray-50 text-2xl text-center md:text-4xl font-serif">Cek Tarif Pengiriman <span class="text-red-600">JNE, POS, TIKI</span></h1>
            </div>
            @if(session('error'))
            <div class="w-11/12 md:w-4/6 flex justify-center items-center" id="notice">
                <p class="w-full p-2 bg-red-200 text-red-600 flex justify-between items-center">{{ session('error') }} <span class="font-bold p-1 cursor-pointer" onclick="closeNotice()">X</span></p>
            </div>
            @endif
            <div class="w-11/12 md:w-4/6 flex justify-center items-center bg-gray-50 p-5">
                <form method="POST" action="{{ route('check.ongkir') }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x text-sm sm:text-base">
                        <div class="flex flex-col overflow-hidden px-5 py-2">
                            <p class="font-bold px-1 mb-2">Asal</p>
                            <select name="origin_prov" onchange="origin_city_on_change(event)" class="bg-transparent text-gray-600 outline-none pb-2">
                                <option value="" disabled selected>--Provinsi--</option>

                                @forelse($provinces as $prov)
                                <option value="{{ $prov->province_id }}">{{ $prov->province }}</option>
                                @empty
                                <option value="" disabled selected>Tidak ada provinsi</option>
                                @endforelse
                            </select>
                            <select name="origin_city" id="origin_cities" class="bg-transparent text-gray-600 outline-none">
                                <option value="" disabled selected>--Kota/Kabupaten--</option>
                            </select>
                        </div>
                        <div class="flex flex-col overflow-hidden px-5 py-2">
                            <p class="font-bold px-1 mb-2">Tujuan</p>
                            <select name="destination_prov" onchange="destination_city_on_change(event)" class="bg-transparent text-gray-600 outline-none pb-2">
                                <option value="" disabled selected>--Provinsi--</option>

                                @forelse($provinces as $prov)
                                <option value="{{ $prov->province_id }}">{{ $prov->province }}</option>
                                @empty
                                <option value="" disabled selected>Tidak ada provinsi</option>
                                @endforelse
                            </select>
                            <select name="destination_city" id="destination_cities" class="bg-transparent text-gray-600 outline-none">
                                <option value="" selected>--Kota/Kabupaten--</option>
                            </select>
                        </div>
                        <div class="flex flex-col overflow-hidden px-5 py-2">
                            <p class="font-bold px-1 mb-2">Berat (Kg)</p>
                            <input type="number" id="weight" name="weight" placeholder="Ex. 1" class="outline-none p-1 bg-transparent">
                            @error('weight')
                            <span class="text-xs text-red-600">* {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col overflow-hidden px-5 py-2 justify-center">
                            <button type="submit" class="text-semibold text-lg py-2 px-5 bg-red-600 hover:bg-red-800 text-gray-50 rounded">Cek Tarif</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="w-full py-10 flex flex-col justify-center items-center">
            @if($noResult ?? false)
            <div class="w-11/12 md:w-4/6 flex justify-center items-center">
                <img src="{{ asset('images/background.jpg') }}" alt="Background" class="w-96">
            </div>
            @endif
            <div class="w-11/12 md:w-4/6">
            @if($originCity ?? false)
            <div class="w-full text-gray-500 flex flex-col md:flex-row justify-between p-3 shadow rounded text-sm mb-10">
                <div class="flex gap-2 px-3">
                    <p>Asal :</p>
                    <p class="text-gray-800 underline italic">{{ $originCity }}</p>
                </div>
                <div class="flex gap-2 px-3">
                    <p>Tujuan :</p>
                    <p class="text-gray-800 underline italic">{{ $destinationCity }}</p>
                </div>
            </div>
            @endif
            @if($jne ?? false)
            @foreach($jne->costs as $j)
            <div class="w-full shadow rounded p-5 mb-5 grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x text-sm">
                <div class="p-2 flex justify-center items-center">
                    <img src="{{ asset('logos/jne.png') }}" alt="JNE logo" class="w-16">
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Agen pengiriman</p>
                    <p>JNE</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Jenis Layanan</p>
                    <p>{{ $j->service }}</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Estimasi</p>
                    <p>{{ $j->cost[0]->etd }} Hari</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Tarif</p>
                    <p>Rp. {{ number_format($j->cost[0]->value, 0 ,",",".") }}</p>
                </div>
            </div>
            @endforeach
            @endif
            @if($pos ?? false)
            @foreach($pos->costs as $j)
            <div class="w-full shadow rounded p-5 mb-5 grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x text-sm">
                <div class="p-2 flex justify-center items-center">
                    <img src="{{ asset('logos/pos.png') }}" alt="POS logo" class="w-16">
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Agen pengiriman</p>
                    <p>JNE</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Jenis Layanan</p>
                    <p>{{ $j->service }}</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Estimasi</p>
                    <p>{{ $j->cost[0]->etd }} Hari</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Tarif</p>
                    <p>Rp. {{ number_format($j->cost[0]->value, 0 ,",",".") }}</p>
                </div>
            </div>
            @endforeach
            @endif
            @if($tiki ?? false)
            @foreach($tiki->costs as $j)
            <div class="w-full shadow rounded p-5 mb-5 grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x text-sm">
                <div class="p-2 flex justify-center items-center">
                    <img src="{{ asset('logos/tiki.png') }}" alt="TIKI logo" class="w-16">
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Agen pengiriman</p>
                    <p>JNE</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Jenis Layanan</p>
                    <p>{{ $j->service }}</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Estimasi</p>
                    <p>{{ $j->cost[0]->etd }} Hari</p>
                </div>
                <div class="px-2">
                    <p class="text-gray-500 mb-1">Tarif</p>
                    <p>Rp. {{ number_format($j->cost[0]->value, 0 ,",",".") }}</p>
                </div>
            </div>
            @endforeach
            @endif
            </div>
        </div>
        <footer class="w-full p-2 bg-[#202020]">
            <p class="text-center text-gray-50">&copy; Copyright by kerelka.com</p>
        </footer>
    </div>


    <script>
        function origin_city_on_change(e) {
            let dataCities = {!! json_encode($cities) !!}

            let cities;
            dataCities.forEach(function(city)  {
                if(city.province_id == e.target.value) {
                    cities += `
                        <option value=${ city.city_id }>${city.city}</option>
                    `;
                }
            })
            let originCitiesEl = document.getElementById('origin_cities');
            originCitiesEl.innerHTML = cities;
        }

        function destination_city_on_change(e) {
            let dataCities = {!! json_encode($cities) !!}

            let cities;
            dataCities.forEach(function(city)  {
                if(city.province_id == e.target.value) {
                    cities += `
                        <option value=${ city.city_id }>${city.city}</option>
                    `;
                }
            })
            let destinationCitiesEl = document.getElementById('destination_cities');
            destinationCitiesEl.innerHTML = cities;
        }

        function closeNotice() {
            let noticeEl = document.getElementById('notice')

            noticeEl.classList.add('hidden');
        }
    </script>
</body>
</html>
