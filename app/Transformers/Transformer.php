<?php

namespace App\Transformers;

use Illuminate\Http\UploadedFile;

interface Transformer
{
	/**
	 * Transform file data into an array.
	 *
	 * @param UploadedFile $file
	 *
	 * @return array
	 */
	public static function execute(UploadedFile $file): array;
}