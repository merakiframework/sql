<?php
declare(strict_types=1);

namespace Meraki\Sql;

use Meraki\Sql\Clause;
use Meraki\TestSuite\TestCase;

final class ClauseTest extends TestCase
{
	/**
	 * @test
	 */
	public function can_be_implemented(): void
	{
		$isInterface = interface_exists(Clause::class);

		$this->assertTrue($isInterface);
	}
}
