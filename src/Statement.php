<?php
declare(strict_types=1);

namespace Meraki\Sql;

use Meraki\Sql\DML\Select;

class Statement
{
	public function select(): Select
	{
		return new Select();
	}
}
