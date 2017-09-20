<?php declare(strict_types = 1);

namespace App\Module\Todo\ReadModel;

use App\Module\Todo\ReadModel\AddedTodo;
use App\Module\Todo\Event\TodoWasAddedEvent;
use App\Module\Todo\Repository\ReadModelTodoRepository;
use Broadway\ReadModel\Projector;

class AddedTodoProjector extends Projector
{
	/**
	 * @var RepositoryInterface
	 */
	private $repository;

	public function __construct(ReadModelTodoRepository $repository)
	{
		$this->repository = $repository;
	}

	public function applyTodoWasAddedEvent(TodoWasAddedEvent $event)
	{
		$addedTodo = new AddedTodo((string) $event->todoId, $event->text);

		$this->repository->save($addedTodo);
	}
}
