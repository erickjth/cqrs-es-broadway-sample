<?php declare(strict_types = 1);

namespace Core\DependencyInjection;

interface DependencyInjectorInterface
{
	/**
	 * Build a class object.
	 *
	 * @param  string $className Class to build
	 *
	 * @return mixed             Object
	 */
	public function create(string $className, array $args = []);
}
