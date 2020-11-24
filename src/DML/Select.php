<?php
declare(strict_types=1);

namespace Meraki\Sql\DML;

use Meraki\Sql\Clause;
use RuntimeException;

final class Select implements Clause
{
	private $columns;
	private $tableName;
	private $where;

	public function __construct()
	{
		$this->columns = [];
		$this->tableName = '';
		$this->where = '';
	}

	/**
	 * Select all columns to be returned from the `SELECT` statement.
	 *
	 * @return	self  ( description_of_the_return_value )
	 */
	public function all(): self
	{
		$this->columns = ['*'];

		return $this;
	}

	/**
	 * Select what columns to be returned from the `SELECT` statement.
	 *
	 * @param	string...  $columns  The columns
	 * @return	self       ( description_of_the_return_value )
	 */
	public function columns(string ...$columns): self
	{
		$this->columns = $columns;

		return $this;
	}

	/**
	 * Add a `FROM` clause to the `SELECT` statement.
	 *
	 * @param	string  $tableName  The table name
	 * @return	self    ( description_of_the_return_value )
	 */
	public function from(string $tableName): self
	{
		$this->tableName = $tableName;

		return $this;
	}

	/**
	 * Add a `WHERE` clause to the `SELECT` statement.
	 *
	 * @param	string  $predicate  The predicate
	 * @return	self    ( description_of_the_return_value )
	 */
	public function where(string $predicate): self
	{
		$this->where = $predicate;

		return $this;
	}

	/**
	 * Get the columns used in the `SELECT` clause.
	 *
	 * @return	array  The columns.
	 */
	public function getSelectClause(): array
	{
		return $this->columns;
	}

	/**
	 * Get the table-name used in the `FROM` clause.
	 *
	 * @return	string  The table name.
	 */
	public function getFromClause(): string
	{
		return $this->tableName;
	}

	/**
	 * Get the predicate used in the `WHERE` clause.
	 *
	 * @return	string  The where clause.
	 */
	public function getWhereClause(): string
	{
		return $this->where;
	}

	public function build(): string
	{
		if (empty($this->columns)) {
			throw new RuntimeException('No rows have been selected.');
		}

		if (empty($this->tableName)) {
			throw new RuntimeException('A table has not been selected.');
		}

		return sprintf('%s %s;', $this->buildSelectClause(), $this->buildFromClause());
	}

	private function buildSelectClause(): string
	{
		return sprintf('SELECT %s', implode(',', $this->columns));
	}

	private function buildFromClause(): string
	{
		if ($this->where) {
			return sprintf('FROM %s WHERE %s', $this->tableName, $this->where);
		}

		return sprintf('FROM %s', $this->tableName);
	}
}
