<?php declare(strict_types = 1);

namespace App\Module\Todo\Repository;

use App\Module\Todo\Repository\ReadModelTodoRepository;
use Broadway\ReadModel\InMemory\InMemoryRepository;

class InMemoryReadModelTodoRepository extends InMemoryRepository implements ReadModelTodoRepository
{
}