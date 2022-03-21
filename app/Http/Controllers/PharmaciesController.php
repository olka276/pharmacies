<?php

namespace App\Http\Controllers;

use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PharmaciesController extends Controller
{
	public function index(Request $request)
	{
		$filters = [
			'name'      => $request->get('name'),
			'post_code' => $request->get('post_code'),
			'city'      => $request->get('city'),
		];

		$pharmaciesQuery = Pharmacy::query();

		$pharmaciesQuery
			->when(!is_null($name = $request->input('name')),
				fn($q) => $q->where('nazwa', 'like', '%' . $name . '%'))
			->when(!is_null($postCode = $request->get('post_code')),
				fn($q) => $q->where('kod_pocztowy', 'like', '%' . $postCode . '%'))
			->when(!is_null($city = $request->get('city')),
				fn($q) => $q->where('miejscowosc', 'like', '%' . $city . '%'));


		$pharmacies = PharmacyResource::collection($pharmaciesQuery->paginate());
		return response()->json($pharmacies, Response::HTTP_OK);
	}
}
