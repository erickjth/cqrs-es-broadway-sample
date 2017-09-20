<?php declare(strict_types = 1);

namespace Core\Container;

use Interop\Container\ContainerInterface;

interface ServiceProvider
{
	/**
	 * @param  Interop\Container\ContainerInterface  $services
	 *
	 * @return Interop\Container\ContainerInterface
	 */
	public function register(ContainerInterface $container) : ContainerInterface;
}