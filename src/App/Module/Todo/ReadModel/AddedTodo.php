<?php declare(strict_types = 1);

namespace App\Module\Todo\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class AddedTodo implements SerializableReadModel
{
	/**
	 * @var int
	 */
	public $todoId;

	/**
	 * @var string
	 */
	public $text;

	public function __construct($todoId, $text)
	{
		$this->todoId = $todoId;
		$this->text = $text;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->todoId;
	}

	/**
	 * @param  array $data
	 * @return mixed The object instance
	 */
	public static function deserialize(array $data)
	{
		return new self($data['todoId'], $data['text']);
	}

	/**
	 * @return array
	 */
	public function serialize()
	{
		return [
			'todoId' => $this->todoId,
			'text' => $this->text
		];
	}
}