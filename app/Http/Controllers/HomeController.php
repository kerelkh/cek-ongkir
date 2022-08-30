<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function index(Request $request) {
        $provinces = Province::all();
        $cities = City::all();
        $noResult = true;

        return view('index', compact(['provinces', 'cities', 'noResult']));
    }

    public function checkOngkir(Request $request) {
        $validator = Validator::make($request->input(), [
            'origin_city' => ['required', 'numeric'],
            'destination_city' => ['required', 'numeric'],
            'weight' => ['required', 'numeric']
        ]);

        if($validator->fails()){
            return back()->with('error', 'Tolong lengkapi data dibawah');
        }

        $RajaOngkir = new RajaOngkirService();
        $response = $RajaOngkir->checkOngkir($request->input());

        if($response == 404) {
            return back()->with('error' , 'Gagal estimasi, tidak boleh lebih dari 30Kg');
        }

        $jne = $response['jne'];
        $pos = $response['pos'];
        $tiki = $response['tiki'];

        if($jne || $pos || $tiki) {
            $originCity = City::where('city_id', $request->origin_city)->pluck('city')->first();
            $destinationCity = City::where('city_id', $request->destination_city)->pluck('city')->first();
            $provinces = Province::all();
            $cities = City::all();
            return view('index', compact(['provinces', 'cities', 'originCity', 'destinationCity', 'jne', 'pos', 'tiki']));
        }

        return back()->with('error', 'Calculating Cost Failed');
    }

}
