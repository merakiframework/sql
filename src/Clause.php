<?php
declare(strict_types=1);

namespace Meraki\Sql;

interface Clause
{
	public function build(): string;
}
