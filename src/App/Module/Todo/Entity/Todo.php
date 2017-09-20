<?php declare(strict_types = 1);

namespace App\Module\Todo\Entity;

use App\Module\Todo\Event\TodoWasAddedEvent;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Modules\Parts\Events\PartWasManufacturedEvent;
use Modules\Parts\Events\PartWasRemovedEvent;

class Todo extends EventSourcedAggregateRoot
{
	private $todoId;
	private $text;

	public static function add($todoId, string $text)
	{
		$todo = new Todo();

		// After instantiation of the object we apply the "TodoWasAdded".
		$todo->apply(new TodoWasAddedEvent($todoId, $text));

		return $todo;
	}

	/**
	 * [getAggregateRootId description]
	 * @return string [description]
	 */
	public function getAggregateRootId()
	{
		return $this->todoId;
	}

	/**
	 * Apply event
	 *
	 * @param  TodoWasAddedEvent $event [description]
	 */
	public function applyTodoWasAddedEvent(TodoWasAddedEvent $event)
	{
		$this->todoId = $event->todoId;
		$this->text = $event->text;
	}
}
