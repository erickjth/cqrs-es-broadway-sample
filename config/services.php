<?php declare(strict_types = 1);

use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Logger;
use Slim\Container;
use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;

$settings = require __DIR__ . '/settings.php';

$container = new Container(['settings' => $settings]);

$services = [
	'logger' => function ($container)
	{
		$settings = $container->get('settings')['logger'];

		$logger = new Logger($settings['name'], [
			new StreamHandler($settings['path'], Logger::DEBUG),
			new StreamHandler($settings['path'], Logger::WARNING),
		], [new PsrLogMessageProcessor]);

		return $logger;
	},

	'twig' => function ($container)
	{
		$settings = $container->get('settings')['paths'];

		$twig = new \Slim\Views\Twig($settings['views'], [
			// 'cache' => $settings['cache']
		]);

		// Instantiate and add Slim specific extension
		$basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
		$twig->addExtension(new Slim\Views\TwigExtension($container['router'], ''));
		$twig->addExtension(new App\Twig\TwigExtension($container->get('settings')));

		return $twig;
	},

	'guzzle' => function ($container)
	{
		$stack = \GuzzleHttp\HandlerStack::create();

		$stack->unshift(
			\GuzzleHttp\Middleware::log(
				$container->get('logger'),
				new \GuzzleHttp\MessageFormatter('{method} {uri} HTTP/{version} {req_body} {code}')
			)
		);

		$guzzle = new Client([
			'handler' => $stack,
		]);

		return $guzzle;
	},

	'database' => function ($container)
	{
		$config = $container->get('settings')['database'];

		$pdo = new \PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
		$pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET time_zone=\'+0:00\'');

		return \Doctrine\DBAL\DriverManager::getConnection(['pdo' => $pdo], new \Doctrine\DBAL\Configuration());
	},

	'dependency-injector' => function ($container) : \Core\DependencyInjection\DependencyInjectorInterface
	{
		$dependencyInjector = new Core\DependencyInjection\StaticMethodInjector($container);
		$dependencyInjector->setFactoryMethod('builder');
		return $dependencyInjector;
	},

	/****************** CQRS AND EVENT SOURCING *************************/
	'command-bus' => function ($container)
	{
		return Core\Bus\Command\CommandBusFactory::createFromContainer($container);
	},

	'query-bus' => function ($container)
	{
		return Core\Bus\Query\QueryBusFactory::createFromContainer($container);
	},

	'event-bus' => function ($container)
	{
		return Core\Bus\Event\EventBusFactory::createFromContainer($container);
	},

	'event-store' => function ($container) : \Broadway\EventStore\EventStore
	{
		return Core\EventStore\EventStoreFactory::createFromContainer($container);
	},

	/****************** SLIM SERVICES *************************/
	// 'errorHandler' => function($container)
	// {
	// 	return function ($request, $response, $exception) use ($container) {
	// 		$container['logger']->error('{error}', [ 'error' => $exception->getMessage() ]);
	// 		return $container['response']->withJson(['error' => $exception->getMessage()])->withStatus(400);
	// 	};
	// },

	// 'notFoundHandler' => function($container)
	// {
	// 	return function ($request, $response) use ($container) {
	// 		return $container['response']->withJson(['error' => 'Page not found'])->withStatus(404);
	// 	};
	// },

	// 'notAllowedHandler' => function($container)
	// {
	// 	return function ($request, $response, $methods) use ($container) {
	// 		return $container['response']->withJson(['error' => 'Method must be one of: ' . implode(', ', $methods)])->withStatus(405);
	// 	};
	// },

	// 'phpErrorHandler' => function($container)
	// {
	// 	return function ($request, $response, $exception) use ($container) {
	// 		$container['logger']->error('PHP ERROR: {file} {line} {error}', [
	// 			'file' => $exception->getFile(),
	// 			'line' => $exception->getLine(),
	// 			'error' => $exception->getMessage(),
	// 		]);

	// 		return $container['response']->withJson([
	// 			'error' => 'Something went wrong.'
	// 		])->withStatus(500);
	// 	};
	// },
];

foreach ($services as $name => $callable)
{
	$container[$name] = $callable;
}

// Apply services providers from modules.
$modules = require __DIR__ . '/modules.php';

foreach ($modules as $module)
{
	if (class_exists($module) === false) continue;
	$reflector = new ReflectionClass($module);
	$provider = $reflector->newInstance();
	if ($provider instanceof \Core\Container\ServiceProvider === false) continue;
	$container = $provider->register($container);
}


return $container;