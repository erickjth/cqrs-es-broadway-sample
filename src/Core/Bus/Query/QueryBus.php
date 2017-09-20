<?php declare(strict_types = 1);

namespace Core\Bus\Query;

use Core\Bus\Message\Query;
use Core\Bus\Handler\QueryHandlerLocator;

interface QueryBus
{
	/**
	 * Query bus constructor
	 *
	 * @param  QueryHandlerLocator $locator  Handler locator
	 */
	function __construct(QueryHandlerLocator $locator);

	/**
	 * Handle the query
	 *
	 * @param  Query $query Query to handle
	 *
	 * @return mixed
	 */
	public function execute(Query $query);
}
