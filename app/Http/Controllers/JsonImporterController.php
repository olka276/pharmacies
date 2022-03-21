<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Transformers\JsonFileTransformer;
use Illuminate\Http\Request;

class JsonImporterController extends Controller
{
    public function __invoke(Request $request) {
		$request->validate([
			'json_file' => 'required|mimes:json'
		]);

		$pharmaciesData = JsonFileTransformer::execute($request->file('json_file'));

//		foreach ($pharmaciesData as $pharmacyData) {
//			Pharmacy::hy
//		}

		Pharmacy::hydrate($pharmaciesData);

		dd(Pharmacy::all());
		dd($jsonData);
	}
}
