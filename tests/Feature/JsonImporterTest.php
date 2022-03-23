<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use finfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
				"nazwa"         => "APT. DOZ",
				"kod_pocztowy"  => "64400",
				"ulica"         => "17 STYCZNIA 96",
				"miejscowosc"   => "Międzychód",
				"gps_dlugosc"   => 15.89888056,
				"gps_szerokosc" => 52.60611111,
			],
			[
				"nazwa"         => "APTEKA CEFARM SPÓŁKA Z O.",
				"kod_pocztowy"  => "00754",
				"ulica"         => "GAGARINA 6",
				"miejscowosc"   => "Warszawa",
				"gps_dlugosc"   => 21.046688,
				"gps_szerokosc" => 52.207158,
			],
			[
				"nazwa"         => "APTEKA S.C. LESZEK GRZEGO",
				"kod_pocztowy"  => "05270",
				"ulica"         => "PIŁSUDSKIEGO 176",
				"miejscowosc"   => "Marki",
				"gps_dlugosc"   => 21.1188028,
				"gps_szerokosc" => 52.3391935,
			],
			[
				"nazwa"         => "APTEKA MEDICA MGR.WIESŁ",
				"kod_pocztowy"  => "12220",
				"ulica"         => "HARCERSKA 1",
				"miejscowosc"   => "Ruciane Nida",
				"gps_dlugosc"   => 21.532384,
				"gps_szerokosc" => 53.639426,
			],
			[
				"nazwa"         => "DOZ CYKOWSKA",
				"kod_pocztowy"  => "98355",
				"ulica"         => "J. PIŁSUDSKIEGO 21 C",
				"miejscowosc"   => "Działoszyn",
				"gps_dlugosc"   => 18.8732416,
				"gps_szerokosc" => 51.1174581,
			]
		], JSON_THROW_ON_ERROR);

		Storage::disk('public')->put('test.json', $fileBase);

		$file_path = storage_path($path = 'app/public/test.json');
		$finfo = new finfo(FILEINFO_MIME_TYPE);

		Pharmacy::query()->delete();
		$countBefore = Pharmacy::all()->count();

		$file = new UploadedFile(
			$file_path,
			$path,
			$finfo->file($file_path),
			filesize($file_path),
			0,
		);

		$data = [
			'json_file' => $file
		];

		$response = $this->json('post', '/api', $data);


		$response
			->assertStatus(Response::HTTP_OK)
			->assertJson([
				"message" => 'Import successful.'
			]);

		$countAfter = Pharmacy::all()->count();

		$this->assertNotEquals($countAfter, $countBefore);
	}

	/**
	 * @return void
	 * @throws \JsonException
	 */
	public function test_should_not_import_invalid_file_to_database()
	{
		$data = [
			'json_file' => UploadedFile::fake()->image('test.jpg')
		];

		Pharmacy::query()->delete();
		$countBefore = Pharmacy::all()->count();

		$this->json('post', '/api', $data)
			 ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			 ->assertJson([
				 "message" => 'Invalid type of file.',
				 "errors" => [
					 'json_file' => [
						 'Invalid type of file.'
					 ]
				 ]
			 ]);

		$countAfter = Pharmacy::all()->count();

		$this->assertEquals($countAfter, $countBefore);
	}
}
