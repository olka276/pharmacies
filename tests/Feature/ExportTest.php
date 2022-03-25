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
					"nazwa"         => "Super apteka",
					"kod_pocztowy"  => "64400",
					"ulica"         => "ulica 11",
					"miejscowosc"   => "KROTOSZYN",
					"gps_dlugosc"   => 1,
					"gps_szerokosc" => 1,
				],
			],
			'filetype' => 'csv'
		];

		$this->json('post', '/api/export', $data)
			 ->assertStatus(Response::HTTP_OK)
			 ->assertHeader('content-disposition');
	}
}
