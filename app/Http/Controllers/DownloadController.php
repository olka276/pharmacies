<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
	/**
	 * Download file from request.
	 *
	 * @param Request $request
	 *
	 * @return BinaryFileResponse
	 */
	public function __invoke(Request $request): BinaryFileResponse
	{
		$filename = $request->input('filename');

		$headers = array(
			'Content-Type: application/octet-stream',
		);

		return response()
			->download(Storage::disk('public')->path('/') . $filename, $filename, $headers)
			->deleteFileAfterSend(false);
    }
}