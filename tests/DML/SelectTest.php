<?php
declare(strict_types=1);

namespace Meraki\Sql\DML;

use Meraki\Sql\DML\Select;
use Meraki\Sql\Clause;
use Meraki\TestSuite\TestCase;
use RuntimeException;

final class SelectTest extends TestCase
{
	/**
	 * @test
	 */
	public function is_a_clause(): void
	{
		$select = new Select();

		$this->assertInstanceOf(Clause::class, $select);
	}

	/**
	 * @test
	 */
	public function new_instance_has_no_columns(): void
	{
		$select = new Select();

		$columns = $select->getSelectClause();

		$this->assertEmpty($columns);
	}

	/**
	 * @test
	 */
	public function new_instance_has_no_table_name_set(): void
	{
		$select = new Select();

		$tableName = $select->getFromClause();

		$this->assertEmpty($tableName);
	}

	/**
	 * @test
	 */
	public function new_instance_has_no_where_clause(): void
	{
		$select = new Select();

		$where = $select->getWhereClause();

		$this->assertEmpty($where);
	}

	/**
	 * @test
	 */
	public function can_select_all_columns(): void
	{
		$select = (new Select())->all();

		$columns = $select->getSelectClause();

		$this->assertEquals(['*'], $columns);
	}

	/**
	 * @test
	 */
	public function can_select_specific_columns(): void
	{
		$expectedColumns = ['name', 'email', 'dob'];
		$select = (new Select())->columns(...$expectedColumns);

		$actualColumns = $select->getSelectClause();

		$this->assertEquals($expectedColumns, $actualColumns);
	}

	/**
	 * @test
	 */
	public function can_set_table_name(): void
	{
		$expectedTableName = 'users';
		$select = (new Select())->all()->from($expectedTableName);

		$actualTableName = $select->getFromClause();

		$this->assertEquals($expectedTableName, $actualTableName);
	}

	/**
	 * @test
	 */
	public function can_set_predicate_of_where_clause(): void
	{
		$expectedPredicate = "users.email = 'test@localhost'";
		$select = (new Select())->all()->from('users')->where($expectedPredicate);

		$actualPredicate = $select->getWhereClause();

		$this->assertEquals($expectedPredicate, $actualPredicate);
	}

	/**
	 * @test
	 */
	public function building_statement_throws_error_if_no_rows_specified(): void
	{
		$expectedException = new RuntimeException('No rows have been selected.');
		$select = new Select();

		$this->expectExceptionObject($expectedException);

		$select->build();
	}

	/**
	 * @test
	 */
	public function building_statement_throws_error_if_no_table_selected(): void
	{
		$expectedException = new RuntimeException('A table has not been selected.');
		$select = (new Select())->all();

		$this->expectExceptionObject($expectedException);

		$select->build();
	}

	/**
	 * @test
	 * @dataProvider validStatements
	 */
	public function building_returns_completed_statement(Select $select, string $expectedStatement): void
	{
		$actualStatement = $select->build();

		$this->assertEquals($expectedStatement, $actualStatement);
	}

	public function validStatements(): array
	{
		return [
			'select all from table' => [
				(new Select())->all()->from('users'),
				'SELECT * FROM users;'
			],
			'select columns from table' => [
				(new Select())->columns('username', 'email')->from('users'),
				'SELECT username,email FROM users;'
			]
		];
	}
}
