<?php

use App\Services\ImporterService;
use Tests\TestCase;

class ImporterServiceTest extends TestCase
{
	private $service;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new ImporterService();
	}

	public function test_should_validate_structure_of_array()
	{
		$validKeys = [
			'cat',
			'dog',
			'parrot'
		];

		$data = [
			'parrot' => 'Billy',
			'cat' => 'John',
			'dog' => 'Will'
		];

		$this->assertTrue($this->service->validateStructureOfArray($data, $validKeys));
    }
	public function test_should_not_validate_invalid_data_by_structure()
	{
		$validKeys = [
			'cat',
			'parrot'
		];

		$data = [
			'parrot' => 'Billy',
			'cat' => 'John',
			'dog' => 'Will'
		];

		$this->assertFalse($this->service->validateStructureOfArray($data, $validKeys));
    }

	public function test_should_add_timestamps_to_array() {
		$array = [];

		$this->service->appendTimestampsToArray($array);

		$this->assertArrayHasKey('created_at', $array);
		$this->assertArrayHasKey('updated_at', $array);
	}
}