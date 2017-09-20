<?php declare(strict_types = 1);

namespace Core\Bus;

use Core\Bus\Message\Query;

interface QueryBus
{
	/**
	 * Execute a query
	 *
	 * @param  Query $command Query to handle
	 *
	 * @return mixed
	 */
	public function execute(Query $query);
}
