<?php declare(strict_types = 1);

namespace Core\Bus\Handler;

use Core\Bus\Message\Command;
use Core\Bus\Handler\CommandHandler;
use Core\DependencyInjection\DependencyInjectorInterface;

class NamespaceCommandHandlerLocator implements CommandHandlerLocator
{
	protected $dependencyInjector;

	/**
	 * Constructor
	 *
	 * @param DependencyInjectorInterface $repository Todo repository
	 */
	public function __construct(DependencyInjectorInterface $dependencyInjector)
	{
		$this->dependencyInjector = $dependencyInjector;
	}

	/**
	 * Return handler for command
	 *
	 * @param  Command $command Command
	 *
	 * @return CommandHandler          Handler
	 */
	public function locate(Command $command) : CommandHandler
	{
		$className = get_class($command);

		$handlerClassName = str_replace('Command', 'Handler', $className);

		return $this->dependencyInjector->create($handlerClassName);
	}
}
