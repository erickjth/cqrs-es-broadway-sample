<?php declare(strict_types = 1);

namespace Core\Bus\Command;

use Core\Bus\Command\SimpleCommandBus;
use Core\Bus\Handler\NamespaceCommandHandlerLocator;
use Interop\Container\ContainerInterface;

class CommandBusFactory
{
	/**
	 * Factory method
	 *
	 * @param  ContainerInterface $container Service container
	 */
	public static function createFromContainer(ContainerInterface $container)
	{
		$commandBus = new SimpleCommandBus(
			new NamespaceCommandHandlerLocator($container['dependency-injector'])
		);

		return $commandBus;
	}
}
