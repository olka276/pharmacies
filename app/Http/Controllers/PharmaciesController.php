<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Services\FilteringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PharmaciesController extends Controller
{
	/**
	 * Get list of Pharmacies
	 *
	 * @param Request          $request
	 * @param FilteringService $service
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request, FilteringService $service): JsonResponse
	{
		$pharmaciesQuery = $service->filter(Pharmacy::class, $request->only(['nazwa', 'kod_pocztowy', 'miejscowosc']));
		return response()->json($pharmaciesQuery->paginate($request->input('pagination') ?? ''), Response::HTTP_OK);
	}
}
