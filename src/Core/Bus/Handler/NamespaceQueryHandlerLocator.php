<?php declare(strict_types = 1);

namespace Core\Bus\Handler;

use Core\Bus\Message\Query;
use Core\Bus\Handler\QueryHandler;
use Core\DependencyInjection\DependencyInjectorInterface;

class NamespaceQueryHandlerLocator implements QueryHandlerLocator
{
	protected $dependencyInjector;

	/**
	 * Constructor
	 *
	 * @param DependencyInjectorInterface $repository Todo repository
	 */
	public function __construct(DependencyInjectorInterface $dependencyInjector)
	{
		$this->dependencyInjector = $dependencyInjector;
	}

	/**
	 * Return handler for query
	 *
	 * @param  Query $query Query
	 *
	 * @return QueryHandler          Handler
	 */
	public function locate(Query $query) : QueryHandler
	{
		$className = get_class($query);

		$handlerClassName = str_replace('Query', 'Handler', $className);

		return $this->dependencyInjector->create($handlerClassName);
	}
}
