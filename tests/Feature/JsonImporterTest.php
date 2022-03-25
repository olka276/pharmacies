<?php

namespace Tests\Feature;

use App\Http\Requests\JsonImporterRequest;
use App\Models\Pharmacy;
use finfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class JsonImporterTest extends TestCase
{
	/**
	 * @return void
	 * @throws \JsonException
	 */
	public function test_should_import_json_file_to_database()
	{
		$fileBase = json_encode([
			[
				"nazwa"         => "Super apteka",
				"kod_pocztowy"  => "64400",
				"ulica"         => "ulica 11",
				"miejscowosc"   => "KROTOSZYN",
				"gps_dlugosc"   => 1,
				"gps_szerokosc" => 1,
			],
		], JSON_THROW_ON_ERROR);

		Storage::disk('public')->put('test.json', $fileBase);
		$filePath = Storage::disk('public')->path('test.json');

		$finfo = new finfo(FILEINFO_MIME_TYPE);

		Pharmacy::query()->delete();
		$countBefore = Pharmacy::all()->count();

		$fileUploaded = new UploadedFile(
			$filePath,
			'test.json',
			$finfo->file($filePath),
			filesize($filePath),
			1,
		);

		$req = Mockery::mock(JsonImporterRequest::class, [
			'passes' => true,
			'all'    => [
				'json_file' => $fileUploaded
			]
		]);

		$this->json('POST', 'api/', $req->all())
			 ->assertStatus(Response::HTTP_OK)
			 ->assertJson([
				 "message" => 'Import successful.'
			 ]);

		$countAfter = Pharmacy::all()->count();

		$this->assertNotEquals($countAfter, $countBefore);
		Storage::disk('public')->delete('test.json');
	}

	/**
	 * @return void
	 */
	public function test_should_not_import_invalid_file_to_database()
	{
		$data = [
			'json_file' => UploadedFile::fake()->image('test.jpg')
		];

		Pharmacy::query()->delete();
		$countBefore = Pharmacy::all()->count();

		$this->json('POST', 'api/', $data)
			 ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			 ->assertJson([
				 "message" => 'Invalid type of file.',
				 "errors"  => [
					 'json_file' => [
						 'Invalid type of file.'
					 ]
				 ]
			 ]);

		$countAfter = Pharmacy::all()->count();
		$this->assertEquals($countAfter, $countBefore);
	}
}
