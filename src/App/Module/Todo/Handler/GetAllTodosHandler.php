<?php declare(strict_types = 1);

namespace App\Module\Todo\Handler;

use App\Module\Todo\Query\GetAllTodosQuery;
use App\Module\Todo\Repository\ReadModelTodoRepository;
use Core\Bus\Handler\QueryHandler;
use Interop\Container\ContainerInterface;

class GetAllTodosHandler implements QueryHandler
{
	/**
	 * @var \App\Module\Todo\Repository\ReadModelTodoRepository $repository Todo repository
	 */
	protected $repository;

	/**
	 * Constructor
	 *
	 * @param ReadModelTodoRepository $repository Todo repository
	 */
	public function __construct(ReadModelTodoRepository $repository = null)
	{
		$this->repository = $repository;
	}

	/**
	 * Factory method
	 *
	 * @param  \Interop\Container\ContainerInterface $container Service Container
	 *
	 * @return \App\Module\Todo\Handler\GetAllTodosHandler Handler
	 */
	public static function builder(ContainerInterface $container)
	{
		$repository = $container->get(ReadModelTodoRepository::class);

		return new self($repository);
	}

	/**
	 * Handle Query
	 *
	 * @param  GetAllTodosQuery $command Query to handle
	 *
	 * @return mixed                    Results
	 */
	public function handle(GetAllTodosQuery $command)
	{
		return $this->repository->findAll();
	}
}
