<?php declare(strict_types = 1);

namespace Core\Domain;

interface Identifier
{
	/**
	 * Generate a new Identifier
	 *
	 * @return Identifier
	 */
	public static function generate() : Identifier;

	/**
	 * Creates an Identifier from a string
	 *
	 * @param $string
	 * @return Identifier
	 */
	public static function fromString($string) : Identifier;

	/**
	 * Determine equality with another Identifier
	 *
	 * @param  Identifier $other
	 * @return bool
	 */
	public function equals(Identifier $other) : bool;

	/**
	 * Return the Identifier as a string
	 *
	 * @return string
	 */
	public function toString() : string;
}