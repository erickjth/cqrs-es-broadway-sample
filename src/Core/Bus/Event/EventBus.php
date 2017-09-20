<?php declare(strict_types = 1);

namespace Core\Bus\Event;

use Core\Bus\Message\Event;

interface EventBus
{
	/**
	 * Publish the Event
	 *
	 * @param  Event $command Event to handle
	 *
	 * @return mixed
	 */
	public function publish(Event $event);
}
