<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExportTest extends TestCase
{
	/**
	 * A basic feature test example.
	 *
	 * @return void
	 */
	public function test_should_export_csv_file()
	{
		$data = [
			'data'     => [
				[
					"id"            => 11,
					"nazwa"         => "APT. DOZ",
					"kod_pocztowy"  => "64400",
					"ulica"         => "17 STYCZNIA 96",
					"miejscowosc"   => "Międzychód",
					"gps_dlugosc"   => 15.89888056,
					"gps_szerokosc" => 52.60611111,
					"created_at"    => "2022-03-21T18:04:38.000000Z",
					"updated_at"    => "2022-03-21T18:04:38.000000Z"
				],
				[
					"id"            => 12,
					"nazwa"         => "APTEKA CEFARM SPÓŁKA Z O.",
					"kod_pocztowy"  => "00754",
					"ulica"         => "GAGARINA 6",
					"miejscowosc"   => "Warszawa",
					"gps_dlugosc"   => 21.046688,
					"gps_szerokosc" => 52.207158,
					"created_at"    => "2022-03-21T18:04:38.000000Z",
					"updated_at"    => "2022-03-21T18:04:38.000000Z"
				],
				[
					"id"            => 13,
					"nazwa"         => "APTEKA S.C. LESZEK GRZEGO",
					"kod_pocztowy"  => "05270",
					"ulica"         => "PIŁSUDSKIEGO 176",
					"miejscowosc"   => "Marki",
					"gps_dlugosc"   => 21.1188028,
					"gps_szerokosc" => 52.3391935,
					"created_at"    => "2022-03-21T18:04:38.000000Z",
					"updated_at"    => "2022-03-21T18:04:38.000000Z"
				],
				[
					"id"            => 14,
					"nazwa"         => "APTEKA MEDICA MGR.WIESŁ",
					"kod_pocztowy"  => "12220",
					"ulica"         => "HARCERSKA 1",
					"miejscowosc"   => "Ruciane Nida",
					"gps_dlugosc"   => 21.532384,
					"gps_szerokosc" => 53.639426,
					"created_at"    => "2022-03-21T18:04:38.000000Z",
					"updated_at"    => "2022-03-21T18:04:38.000000Z"
				],
				[
					"id"            => 15,
					"nazwa"         => "DOZ CYKOWSKA",
					"kod_pocztowy"  => "98355",
					"ulica"         => "J. PIŁSUDSKIEGO 21 C",
					"miejscowosc"   => "Działoszyn",
					"gps_dlugosc"   => 18.8732416,
					"gps_szerokosc" => 51.1174581,
					"created_at"    => "2022-03-21T18:04:38.000000Z",
					"updated_at"    => "2022-03-21T18:04:38.000000Z"
				]
			],
			'filetype' => 'csv'
		];

		$this->json('post', '/api/export', $data)
			 ->assertStatus(Response::HTTP_OK)
			 ->assertJsonFragment([
				 "mime_type" => "text/csv"
			 ]);

	}
}
