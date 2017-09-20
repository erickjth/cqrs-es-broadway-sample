<?php declare(strict_types = 1);

namespace Core\Bus\Command;

use Core\Bus\Command\CommandBus;
use Core\Bus\Message\Command;
use Core\Bus\Handler\CommandHandlerLocator;

class SimpleCommandBus implements CommandBus
{
	/**
	 * @var CommandHandlerLocator Handler locator
	 */
	protected $handlerLocator;

	/**
	 * Command bus constructor
	 *
	 * @param  CommandHandlerLocator $locator  Handler locator
	 */
	function __construct(CommandHandlerLocator $locator)
	{
		$this->handlerLocator = $locator;
	}

	/**
	 * Handle the command
	 *
	 * @param  Command $command Command to handle
	 *
	 * @return void           Nothing to result
	 */
	public function execute(Command $command)
	{
		$handler = $this->handlerLocator->locate($command);
		$handler->handle($command);
	}
}
