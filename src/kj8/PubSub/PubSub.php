<?php

namespace kj8\PubSub;

class PubSub {
	private function __construct() {
		
	}
	private function __clone() {

	}

	private static $events = array();

	public static function on($eventName, $callaback) {
		if (!is_callable($callaback)) {
			throw new PubSubException('Value is not callable!');
		}
		self::$events[$eventName] = $callaback;
	}

	public static function off($eventName) {
		self::$events[$eventName] = null;
	}

	public static function trigger($eventName) {
		if (!isset(self::$events[$eventName])) {
			throw new PubSubException('Event does not exists!');
		}

		if (!is_callable(self::$events[$eventName])) {
			throw new PubSubException('Value is not callable!');
		}

		$params = func_get_args();
		array_shift($params);
		return call_user_func_array(self::$events[$eventName], $params);
	}
	
	public static function keys() {
		return array_keys(self::$events);
	}
}
