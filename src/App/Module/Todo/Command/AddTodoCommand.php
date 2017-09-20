<?php declare(strict_types = 1);

namespace App\Module\Todo\Command;

use Core\Bus\Message\Command;
use Core\Domain\Identifier;

/**
 * Add a new todo command
 */
class AddTodoCommand implements Command
{
	/**
	 * @var  Core\Domain\Identifier Todo Id
	 */
	protected $todoId;

	/**
	 * @var string Todo text
	 */
	protected $text;

	/**
	 * Command constructor
	 *
	 * @param Identifier $todoId  Todo Id
	 * @param string     $text    Todo text
	 */
	public function __construct(Identifier $todoId, string $text)
	{
		$this->todoId = $todoId;
		$this->text = $text;
	}

	/**
	 * @return  Core\Domain\Identifier Todo Id
	 */
	public function getTodoId() : Identifier
	{
		return $this->todoId;
	}

	/**
	 * @return string Todo text
	 */
	public function getText() : string
	{
		return $this->text;
	}
}
