<?php

namespace App\Services;

use App\Models\Pharmacy;

class FilteringService
{
	public function filter($model, $filterArray)
	{
		$model = $model::query();

		foreach ($filterArray as $key => $filter) {
			$model = $model->where($key, 'like', '%' . $filter . '%');
		}

		return $model;
	}
}