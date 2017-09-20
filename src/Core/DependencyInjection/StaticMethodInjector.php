<?php declare(strict_types = 1);

namespace Core\DependencyInjection;

use Core\DependencyInjection\DependencyInjectorInterface;
use Exception;
use ReflectionException;
use ReflectionClass;
use ReflectionMethod;
use Interop\Container\ContainerInterface;

/**
 * This class creates a object from a static method like a factory method
 *
 * e.g:
 *  class Foo
 *  {
 *    public $bar;
 *
 *    public function __construct(Bar $bar)
 *    {
 *      $this->bar = $bar
 *    }
 *
 *    static public function factoryMethod(Container $services)
 *    {
 *       return new Foo($services->get(Bar::class));
 *    }
 *  }
 */
class StaticMethodInjector implements DependencyInjectorInterface
{
	/**
	 * @var Interop\Container\ContainerInterface $services
	 */
	protected $services;

	/**
	 * @var string Name of method for factoring class
	 */
	protected $factoryMethod;

	/**
	 * Class Constructor
	 *
	 * @param  Interop\Container\ContainerInterface  $services
	 */
	public function __construct(ContainerInterface $services)
	{
		$this->services = $services;
		$this->factoryMethod = 'factoryMethod';
	}

	/**
	 * Set a static method name from the class
	 *
	 * @param string $factoryMethod Static method name
	 */
	public function setFactoryMethod(string $factoryMethod)
	{
		$this->factoryMethod = $factoryMethod;
	}

	/**
	 * Build a class object.
	 *
	 * @param  string $className Class to build
	 *
	 * @return mixed             Object
	 */
	public function create(string $className, array $args = [])
	{
		try
		{
			$reflector = new ReflectionClass($className);

			if ($this->factoryMethod === '')
			{
				throw new InvalidArgumentException('The factory method is not defined.');
			}

			// Checking if the target class has a static and public factory
			$method = new ReflectionMethod($className, $this->factoryMethod);

			if ($method->isStatic() === false || $method->isPublic() === false)
			{
				throw new InvalidArgumentException('The factory method is not static or public.');
			}

			$object = $method->invoke(null, $this->services);

			if ($reflector->isInstance($object) === false)
			{
				throw new InvalidArgumentException('The factory method returns an invalid object.');
			}

			return $object;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
}
