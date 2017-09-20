<?php declare(strict_types = 1);

namespace App\Module\Todo\Query;

use Core\Bus\Message\Query;

/**
 * Get all todos query
 */
class GetAllTodosQuery implements Query
{
	/**
	 * Query constructor
	 */
	public function __construct()
	{
	}
}
