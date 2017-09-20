<?php declare(strict_types = 1);

namespace App\Module\Todo\Repository;

use App\Module\Todo\Entity\Todo;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

/**
 * A repository that will only store and retrieve Todo aggregate roots.
 *
 * This repository uses the base class provided by the EventSourcing component.
 */
class EventStoreTodoRepository extends EventSourcingRepository
{
	public function __construct(EventStore $eventStore, EventBus $eventBus)
	{
		parent::__construct($eventStore, $eventBus, Todo::class, new PublicConstructorAggregateFactory());
	}
}