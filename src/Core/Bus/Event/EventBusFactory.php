<?php declare(strict_types = 1);

namespace Core\Bus\Event;

use Broadway\EventHandling\SimpleEventBus;
use Interop\Container\ContainerInterface;

class EventBusFactory
{
	/**
	 * Factory method
	 *
	 * @param  ContainerInterface $container Service container
	 */
	public static function createFromContainer(ContainerInterface $container)
	{
		$eventBus = new SimpleEventBus();

		return $eventBus;
	}
}
