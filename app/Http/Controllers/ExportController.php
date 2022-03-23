<?php

namespace App\Http\Controllers;

use App\Exporters\CsvExporter;
use App\Exporters\Exporter;
use App\Exporters\JsonExporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\MockObject\UnknownClassException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ExportController extends Controller
{
	/**
	 * Export file.
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 * @throws \JsonException
	 */
	public function __invoke(Request $request): JsonResponse
	{
		$data = $request->validate([
			'data'     => 'required|array',
			'filetype' => 'required'
		]);

		switch ($request->input('filetype')) {
			case 'csv':
				$exporter = new CsvExporter();
				break;
			case 'json':
				$exporter = new JsonExporter();
				break;
		}

		if (!$exporter instanceof Exporter) {
			throw new UnknownClassException('Class is not instance of Exporter interface.');
		}

		$filename = $exporter->execute(Arr::get($data, 'data'));

		return response()->json([
			'data'      => $filename,
			'mime_type' => Storage::disk('public')->mimeType($filename)
		]);
	}
}