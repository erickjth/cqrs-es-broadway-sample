<?php declare(strict_types = 1);

namespace Core\DependencyInjection;

use Core\DependencyInjection\DependencyInjectorInterface;
use Exception;
use ReflectionException;
use ReflectionClass;
use ReflectionMethod;
use Interop\Container\ContainerInterface;

/**
 * This class creates and injects dependencies from a Container magically.
 */
class AutoWiringInjector implements DependencyInjectorInterface
{
	/**
	 * @var Interop\Container\ContainerInterface $services
	 */
	protected $services;

	/**
	 * Class Constructor
	 *
	 * @param  Interop\Container\ContainerInterface  $services
	 */
	public function __construct(ContainerInterface $services)
	{
		$this->services = $services;
	}

	/**
	 * Build a class object injecting services from container.
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

			// Get target class constructor to inject dependences
			$constructor = $reflector->getConstructor();

			$arguments = [];

			if ($constructor !== null)
			{
				$arguments = $this->injectServices($constructor, $args);
			}

			return $reflector->newInstanceArgs($arguments);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	/**
	 * This method tries to inject services using the parameter names and the services key
	 *
	 * @param  \ReflectionMethod $method classContructor
	 * @param  array             $args   Arguments by defaults
	 *
	 * @return array                     Array with arguments
	 */
	private function injectServices(ReflectionMethod $method, array $args = []) : array
	{
		$arguments = [];

		if ($method->getNumberOfParameters() > 0)
		{
			// Inject dependences
			foreach ($method->getParameters() as $parameter)
			{
				$parameterkey = $parameter->getPosition();
				$parameterName = $parameter->getName();
				$parameterValue = null;

				// Get parameter name as snake format. This will be to check services by name
				$parameterNameAsSnake = strtolower(
					preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", $parameterName)
				);

				// Add parameter by given name
				if (isset($args[$parameterName]) === true)
				{
					$parameterValue = $args[$parameterName];
				}
				// Add parameter by position number
				else if (isset($args[$parameterkey]) === true)
				{
					$parameterValue = $args[$parameterkey];
				}
				// Checking service by name in the container
				else if (isset($this->services[$parameterNameAsSnake]))
				{
					$parameterValue = $this->services[$parameterNameAsSnake];
				}
				else if ($parameter->hasType() === true && $parameter->getType()->isBuiltin() === false)
				{
					$parameterType = (string) $parameter->getType();

					if ($this->services->has($parameterType) === true)
					{
						$parameterValue = $this->services->get($parameterType);
					}
				}

				if ($parameterValue !== null)
				{
					if ($parameter->hasType() === true)
					{
						$paramType = gettype($parameterValue) === 'object' ?
							get_class($parameterValue) :
							gettype($parameterValue);

						$expectedType = (string) $parameter->getType();

						// Check if required type is the same to the provided type
						if (
							is_a($parameterValue, $expectedType) !== true &&
							(
								$parameter->getType()->isBuiltin() === true &&
								$paramType !== $expectedType
							)
						)
						{
							throw new Exception('Invalid provided value for ' . $parameter->getName() .'. Given: ' . $paramType . ', Expected: ' . $expectedType);
						}
					}
				}
				else if ($parameter->isDefaultValueAvailable() === true)
				{
					$parameterValue = $parameter->getDefaultValue();
				}
				// If the parameter is not optional
				else if ($parameter->isOptional() === false)
				{
					throw new Exception("Required parameter is needed. Parameter: '" . $parameter->getName() . "' instance of '" . $parameter->getClass()->name . "'");
				}

				// Set parameter
				$arguments[$parameterkey] = $parameterValue;
			}
		}

		return $arguments;
	}
}
