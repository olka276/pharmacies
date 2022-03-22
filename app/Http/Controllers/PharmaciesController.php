<?php

namespace App\Http\Controllers;

use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PharmaciesController extends Controller
{
	/**
	 * Get list of Pharmacies
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$pharmaciesQuery = Pharmacy::query();

		$pharmaciesQuery
			->when(!is_null($name = $request->input('name')),
				fn($q) => $q->where('nazwa', 'like', '%' . $name . '%'))
			->when(!is_null($postCode = $request->get('post_code')),
				fn($q) => $q->where('kod_pocztowy', 'like', '%' . $postCode . '%'))
			->when(!is_null($city = $request->get('city')),
				fn($q) => $q->where('miejscowosc', 'like', '%' . $city . '%'));

//		dd($pharmaciesQuery->paginate());
		return response()->json($pharmaciesQuery->paginate(), Response::HTTP_OK);
	}
}
