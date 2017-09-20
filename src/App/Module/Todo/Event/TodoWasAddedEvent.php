<?php declare(strict_types = 1);

namespace App\Module\Todo\Event;

use Core\Bus\Message\Event;
use Core\Domain\Identifier;
use Broadway\Serializer\Serializable;

/**
 * TodoWasAdded Event
 */
class TodoWasAddedEvent implements Event, Serializable
{
	/**
	 * @var  Core\Domain\Identifier Todo Id
	 */
	public $todoId;

	/**
	 * @var string Todo text
	 */
	public $text;

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
	 * @param  array $data
	 * @return mixed The object instance
	 */
	public static function deserialize(array $data)
	{
		$todoId = UuidIdentifier::fromString($data['partId']);
		return new self($todoId, $data['text']);
	}

	/**
	 * @return array
	 */
	public function serialize()
	{
		return [
			'todoId' => $this->todoId->toString(),
			'text' => $this->text,
		];
	}
}
