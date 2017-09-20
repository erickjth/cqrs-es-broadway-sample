<?php declare(strict_types = 1);

namespace Core\Bus\Handler;

use Core\Bus\Message\Query;
use Core\Bus\Handler\QueryHandler;

interface QueryHandlerLocator
{
	/**
	 * Return handler for query
	 *
	 * @param  Query $query Query
	 *
	 * @return QueryHandler           Nothing to result
	 */
	public function locate(Query $query) : QueryHandler;
}
