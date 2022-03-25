<?php

namespace App\Http\Controllers;

use App\Http\Requests\JsonImporterRequest;
use App\Models\Pharmacy;
use App\Services\ImporterService;
use App\Transformers\JsonFileTransformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonImporterController extends Controller
{
	/**
	 * Import pharmacies JSON data to Database
	 *
	 * @param JsonImporterRequest $request
	 * @param ImporterService     $service
	 *
	 * @return JsonResponse
	 * @throws \JsonException
	 */
	public function __invoke(JsonImporterRequest $request, ImporterService $service): JsonResponse
	{
		//Tests are not passing when 'required' rule included in Request
		if(is_null($request->file('json_file'))) {
			return response()->json([
				'message' => 'File not given.'
			], Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$pharmaciesData = JsonFileTransformer::execute($request->file('json_file'));

		foreach ($pharmaciesData as &$pharmacyData) {
			$isValid = $service->validateStructureOfArray($pharmacyData, [
				'nazwa',
				'kod_pocztowy',
				'ulica',
				'miejscowosc',
				'gps_dlugosc',
				'gps_szerokosc'
			]);

			if (!$isValid) {
				return response()->json([
					'message' => 'File structure is invalid.'
				], Response::HTTP_UNPROCESSABLE_ENTITY);
			}

			$service->appendTimestampsToArray($pharmacyData);
		}

		//unset to prevent possible side-effects
		unset($pharmacyData);

		try {
			$service->replaceModelsByNewData(Pharmacy::class, $pharmaciesData);
		} catch (\Exception $exception) {
			return response()->json([
				'message' => 'An error has occurred.',
				'details' => $exception->getMessage()
			], Response::HTTP_OK);
		}

		return response()->json([
			'message' => 'Import successful.'
		], Response::HTTP_OK);
	}
}
