<?php declare(strict_types = 1);

namespace Core\Domain;

use Ramsey\Uuid\Uuid;

class UuidIdentifier implements Identifier
{
	protected $value;

	function __construct($identifier)
	{
		$this->value = $identifier;
	}

	/**
	 * Generate a new Identifier
	 *
	 * @return Identifier
	 */
	public static function generate() : Identifier
	{
		return new static(Uuid::uuid4());
	}

	/**
	 * Creates an identifier object from a string
	 *
	 * @param $string
	 * @return Identifier
	 */
	public static function fromString($string) : Identifier
	{
		return new static(Uuid::fromString($string));
	}

	/**
	 * Determine equality with another Value Object
	 *
	 * @param  Identifier $other
	 * @return bool
	 */
	public function equals(Identifier $other) : bool
	{
		return $this == $other;
	}

	/**
	 * Return the identifier as a string
	 *
	 * @return string
	 */
	public function toString() : string
	{
		return $this->value->toString();
	}

	/**
	 * Return the identifier as a string
	 *
	 * @return string
	 */
	public function __toString() : string
	{
		return $this->value->toString();
	}
}
