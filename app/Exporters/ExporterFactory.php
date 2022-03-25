<?php

namespace App\Exporters;

use App\Exporters\Exporter as IExporter;
use Error;

class ExporterFactory
{
	public function export($format): IExporter
	{
		return match ($format) {
			'csv'   => new CsvExporter(),
			'json'  => new JsonExporter(),
			default => throw new Error('Exporter not found'),
		};
	}
}