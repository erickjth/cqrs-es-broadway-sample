<?php declare(strict_types = 1);

namespace Core\Bus\Query;

use Core\Bus\Query\SimpleQueryBus;
use Core\Bus\Handler\NamespaceQueryHandlerLocator;
use Interop\Container\ContainerInterface;

class QueryBusFactory
{
	/**
	 * Factory method
	 *
	 * @param  ContainerInterface $container Service container
	 */
	public static function createFromContainer(ContainerInterface $container)
	{
		$queryBus = new SimpleQueryBus(
			new NamespaceQueryHandlerLocator($container['dependency-injector'])
		);

		return $queryBus;
	}
}
