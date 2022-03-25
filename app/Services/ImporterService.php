<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImporterService
{
	/**
	 * Determines if keys of array are equals to given structure array.
	 *
	 * @param array $array Validated array
	 * @param array $structure Array of valid keys
	 *
	 * @return bool
	 */
	public function validateStructureOfArray(array $array, array $structure): bool
	{
		return empty(array_diff(array_keys($array), $structure));
	}

	/**
	 * Add timestamp to array
	 *
	 * @param array $array
	 *
	 * @return void
	 */
	public function appendTimestampsToArray(array &$array): void
	{
		$array['created_at'] = Carbon::now()->toDateTimeString();
		$array['updated_at'] = Carbon::now()->toDateTimeString();
	}

	/**
	 * Delete all models and create new ones based on given data
	 *
	 * @param mixed $model Name of model's class
	 * @param array $array Array of new models data
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function replaceModelsByNewData(mixed $model, array $array): void
	{
		DB::beginTransaction();

		try {
			$model::query()->delete();
			$model::insert($array);
			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			throw $e;
		}
	}
}