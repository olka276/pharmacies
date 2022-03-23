<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Transformers\JsonFileTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class JsonImporterController extends Controller
{
	/**
	 * Import pharmacies JSON data to Database
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 * @throws \JsonException
	 */
	public function __invoke(Request $request): JsonResponse
	{
		$request->validate([
			'json_file' => [
				function($attribute, $value, $fail) {
					$extension = $value->getClientOriginalExtension();
					if($extension !== 'json') {
						$fail('Invalid type of file.');
					}
				}
			]
		]);

		$pharmaciesData = JsonFileTransformer::execute($request->file('json_file'));

		foreach ($pharmaciesData as &$pharmacyData) {
			$pharmacyData['created_at'] = Carbon::now()->toDateTimeString();
			$pharmacyData['updated_at'] = Carbon::now()->toDateTimeString();
		}

		unset($pharmacyData);

		DB::beginTransaction();

		try {
			Pharmacy::query()->delete();
			Pharmacy::insert($pharmaciesData);
			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			throw $e;
		}
		return response()->json([
			'message' => 'Import successful.'
		], Response::HTTP_OK);
	}
}
