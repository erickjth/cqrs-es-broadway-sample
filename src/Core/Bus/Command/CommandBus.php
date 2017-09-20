<?php declare(strict_types = 1);

namespace Core\Bus\Command;

use Core\Bus\Message\Command;
use Core\Bus\Handler\CommandHandlerLocator;

interface CommandBus
{
	/**
	 * Command bus constructor
	 *
	 * @param  CommandHandlerLocator $locator  Handler locator
	 */
	function __construct(CommandHandlerLocator $locator);

	/**
	 * Handle the command
	 *
	 * @param  Command $command Command to handle
	 *
	 * @return void           Nothing to result
	 */
	public function execute(Command $command);
}
