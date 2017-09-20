<?php declare(strict_types = 1);

namespace Core\EventStore;

use Broadway\EventStore\EventStore;
use Broadway\EventStore\Dbal\DBALEventStore;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Broadway\UuidGenerator\Converter\BinaryUuidConverter;
use Interop\Container\ContainerInterface;

class EventStoreFactory
{
	/**
	 * Invokable method
	 *
	 * @param  ContainerInterface $container Service container
	 *
	 * @return \Broadway\EventStore\EventStore
	 */
	public static function createFromContainer(ContainerInterface $container)
	{
		$connection = $container->get('database');
		$schemaManager = $connection->getSchemaManager();
		$schema = $schemaManager->createSchema();

		$eventStore = new DBALEventStore(
			$connection,
			new SimpleInterfaceSerializer(),
			new SimpleInterfaceSerializer(),
			$container->get('settings')['cqrs-es']['event-store']['table'],
			false,
			new BinaryUuidConverter()
		);

		if ($table = $eventStore->configureSchema($schema) !== null)
		{
			$schemaManager->createTable($table);
		}

		return $eventStore;
	}
}
