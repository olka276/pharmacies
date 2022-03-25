<?php

namespace App\Http\Controllers;

use App\Exporters\ExporterFactory;
use App\Http\Requests\ExportRequest;
use Illuminate\Http\JsonResponse;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
	/**
	 * Export file.
	 *
	 * @param ExportRequest   $request
	 * @param ExporterFactory $factory
	 *
	 * @return BinaryFileResponse|JsonResponse
	 */
	public function __invoke(ExportRequest $request, ExporterFactory $factory): BinaryFileResponse|JsonResponse
	{
		$exporter = $factory->export($extension = $request->input('filetype'));

		$file = $exporter->execute($request->input('data'));

		$headers = [
			'Content-Type: application/octet-stream',
		];

		//deletes file after send
		try {
			return response()
				->download($file, time().".".$extension, $headers)->deleteFileAfterSend(true);
		} catch (Exception $exception) {

			//delete file when exception was thrown
			unlink($file);
			return response()->json([
				'message' => $exception->getMessage()
			]);
		}

	}
}