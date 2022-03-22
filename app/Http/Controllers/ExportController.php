<?php

namespace App\Http\Controllers;

use App\Exporters\CsvExporter;
use App\Exporters\Exporter;
use App\Exporters\JsonExporter;
use Illuminate\Http\Request;
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
	 * @return BinaryFileResponse
	 * @throws \JsonException
	 */
	public function __invoke(Request $request): BinaryFileResponse
	{
		$data = $request->input('data');

		$exporter = new JsonExporter();

		if(!$exporter instanceof Exporter) {
			throw new UnknownClassException('Class is not instance of Exporter interface.');
		}

		$filename = $exporter->execute($data);

		$headers = array(
			'Content-Type: application/octet-stream',
		);

		return response()
			->download(Storage::disk('public')->path('/').$filename, $filename, $headers)
			->deleteFileAfterSend(true);
    }
}