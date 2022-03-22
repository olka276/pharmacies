<?php

namespace App\Exporters;

interface Exporter
{
	/**
	 * Transform data array into file and return filename.
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function execute(array $data): string;
}