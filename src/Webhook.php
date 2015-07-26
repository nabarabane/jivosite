<?php

namespace Jivosite;

class Webhook
{
	private $hooks;

	public function __construct()
	{
		$this->hooks = array();
	}

	private function getCallbacks($name)
	{
		return isset($this->hooks[$name]) ? $this->hooks[$name] : array();
	}

	public function on($name, $callback)
	{
		if (!is_callable($callback, true)) {
			throw new \InvalidArgumentException(sprintf('Invalid callback: %s.', print_r($callback, true)));
		}

		$this->hooks[$name][] = $callback;
	}

	public function listen()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		if (empty($data)) {
			return false;
		}

		$event = $data['event_name'];

		foreach($this->getCallbacks($event) as $callback) {
			call_user_func($callback, $data, $this);
		}
	}

	public function respond($response = array())
	{
		if (!empty($response)) {
			header('Content-Type: application/json; charset=utf-8');
			die(json_encode($response));
		}
	}
}
