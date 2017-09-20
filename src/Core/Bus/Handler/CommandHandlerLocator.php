<?php declare(strict_types = 1);

namespace Core\Bus\Handler;

use Core\Bus\Message\Command;
use Core\Bus\Handler\CommandHandler;

interface CommandHandlerLocator
{
	/**
	 * Return handler for command
	 *
	 * @param  Command $command Command
	 *
	 * @return CommandHandler           Nothing to result
	 */
	public function locate(Command $command) : CommandHandler;
}
