<?php declare(strict_types = 1);

namespace App\Module\Todo\Handler;

use App\Module\Todo\Command\AddTodoCommand;
use App\Module\Todo\Entity\Todo;
use App\Module\Todo\Repository\EventStoreTodoRepository;
use Core\Bus\Handler\CommandHandler;
use Core\Domain\Identifier;
use Interop\Container\ContainerInterface;

class AddTodoHandler implements CommandHandler
{
	/**
	 * @var \App\Module\Todo\Repository\EventStoreTodoRepository $repository Todo repository
	 */
	protected $repository;

	/**
	 * Constructor
	 *
	 * @param EventStoreTodoRepository $repository Todo repository
	 */
	public function __construct(EventStoreTodoRepository $repository = null)
	{
		$this->repository = $repository;
	}

	/**
	 * Factory method
	 *
	 * @param  \Interop\Container\ContainerInterface $container Service Container
	 *
	 * @return \App\Module\Todo\Handler\AddTodoHandler Handler
	 */
	public static function builder(ContainerInterface $container)
	{
		$repository = new EventStoreTodoRepository($container['event-store'], $container['event-bus']);

		return new self($repository);
	}

	/**
	 * Handle command
	 *
	 * @param  AddTodoCommand $command Command to handle
	 *
	 * @return void
	 */
	public function handle(AddTodoCommand $command) : void
	{
		$todo = Todo::add($command->getTodoId(), $command->getText());

		$this->repository->save($todo);
	}
}
