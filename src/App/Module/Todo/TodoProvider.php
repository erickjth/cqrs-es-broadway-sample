<?php declare(strict_types = 1);

namespace App\Module\Todo;

use App\Module\Todo\ReadModel\AddedTodoProjector;
use App\Module\Todo\Repository\InMemoryReadModelTodoRepository;
use App\Module\Todo\Repository\ReadModelTodoRepository;
use Core\Container\ServiceProvider;
use Closure;
use Interop\Container\ContainerInterface;

class TodoProvider implements ServiceProvider
{
	/**
	 * @param  Interop\Container\ContainerInterface  $services
	 *
	 * @return Interop\Container\ContainerInterface
	 */
	public function register(ContainerInterface $container) : ContainerInterface
	{
		$container[ReadModelTodoRepository::class] = function ($container)
		{
			return new InMemoryReadModelTodoRepository;
		};

		// Projectors
		$addedTodoProjector = new AddedTodoProjector($container->get(ReadModelTodoRepository::class));

		// Subscribe events
		$container->get('event-bus')->subscribe($addedTodoProjector);

		return $container;
	}
}