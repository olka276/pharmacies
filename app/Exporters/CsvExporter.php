<?php

namespace App\Exporters;

use Illuminate\Support\Facades\Storage;

class CsvExporter implements Exporter
{
	/**
	 * Transform data array into file and return filename.
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function execute(array $data): string
	{
		$filename = time()."-search-results.csv";
		$fp = fopen(Storage::disk('public')->path('/').$filename, 'wb');

		foreach ($data as $fields) {
			fputcsv($fp, $fields);
		}

		fclose($fp);
		return $filename;
	}
}