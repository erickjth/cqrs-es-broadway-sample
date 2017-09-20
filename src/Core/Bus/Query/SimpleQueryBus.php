<?php declare(strict_types = 1);

namespace Core\Bus\Query;

use Core\Bus\Query\QueryBus;
use Core\Bus\Message\Query;
use Core\Bus\Handler\QueryHandlerLocator;

class SimpleQueryBus implements QueryBus
{
	/**
	 * @var QueryHandlerLocator Handler locator
	 */
	protected $handlerLocator;

	/**
	 * Query bus constructor
	 *
	 * @param  QueryHandlerLocator $locator  Handler locator
	 */
	function __construct(QueryHandlerLocator $locator)
	{
		$this->handlerLocator = $locator;
	}

	/**
	 * Handle the query
	 *
	 * @param  Query $query Query to handle
	 *
	 * @return mixed           Result
	 */
	public function execute(Query $query)
	{
		$handler = $this->handlerLocator->locate($query);

		return $handler->handle($query);
	}
}
