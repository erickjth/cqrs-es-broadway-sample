<?php declare(strict_types = 1);

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Module\Todo\Command\AddTodoCommand;
use App\Module\Todo\Query\GetAllTodosQuery;
use Core\Domain\UuidIdentifier;

/**
* Home controller
*/
class HomeController extends AbstractController
{
	/**
	 * Home
	 *
	 * @param  ServerRequestInterface $request   Request object.
	 * @param  ResponseInterface      $response  Response object.
	 *
	 * @return ResponseInterface                 Response
	 */
	public function getIndexAction(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
	{
		$command = new AddTodoCommand(UuidIdentifier::generate(), 'Foo');

		$this->services->get('command-bus')->execute($command);

		$query = new GetAllTodosQuery();

		$todos = $this->services->get('query-bus')->execute($query);

		return $this->getTwig()->render($response, 'home.twig', [
			'todos' => $todos,
		]);
	}
}