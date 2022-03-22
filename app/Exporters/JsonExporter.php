<?php

namespace App\Exporters;
use Illuminate\Support\Facades\Storage;

class JsonExporter implements Exporter
{
	/**
	 * Transform data array into file and return filename.
	 *
	 * @param array $data
	 *
	 * @return string
	 * @throws \JsonException
	 */
	public function execute(array $data): string
	{
		$filename = time()."-search-results.json";
		$encoded = json_encode($data, JSON_THROW_ON_ERROR);
		Storage::disk('public')->put($filename, $encoded, 'public');

		return $filename;
	}
}