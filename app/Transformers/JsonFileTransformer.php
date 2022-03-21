<?php

namespace App\Transformers;

use Illuminate\Http\UploadedFile;
use JsonException;
use App\Transformers\Transformer as ITransformer;

class JsonFileTransformer implements ITransformer
{
	/**
	 * Transform file data into an array.
	 *
	 * @param UploadedFile $file
	 *
	 * @return array
	 * @throws JsonException
	 */
	public static function execute(UploadedFile $file): array
	{
		$jsonString = file_get_contents($file);
		return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
	}
}