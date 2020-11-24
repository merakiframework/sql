<?php
declare(strict_types=1);

namespace Meraki\Sql;

use Meraki\Sql\Statement;
use Meraki\Sql\DML\Select;
use Meraki\TestSuite\TestCase;

final class StatementTest extends TestCase
{
	/**
	 * @test
	 */
	public function object_exists(): void
	{
		$objExists = class_exists(Statement::class);

		$this->assertTrue($objExists);
	}

	/**
	 * @test
	 */
	public function can_create_select_query_statement(): void
	{
		$stmt = new Statement();

		$instance = $stmt->select();

		$this->assertInstanceOf(Select::class, $instance);
	}
}
