<?php namespace Viimed\PhpApi;

use ReflectionClass, InvalidArgumentException, BadMethodCallException;
use Viimed\PhpApi\Gateways\Gateway;

class GatewayManager {

	private $gateways = [];

	public function setGateway(Gateway $gateway, $index = NULL)
	{
		$index = is_null($index) ? static::getIndexName( $gateway ) : $index;

		if(isset($this->gateways[$index]))
			throw new InvalidArgumentException("Gateway index is already registered.");

		$this->gateways[$index] = $gateway;

		return $this;
	}

	public function getGateway($index)
	{
		if( ! isset($this->gateways[$index]))
			throw new BadMethodCallException("Gateway index '$index' is not registered.");

		return $this->gateways[$index];
	}

	public function removeGateway($index)
	{
		unset($this->gateways[$index]);

		return $this;
	}

	public static function getIndexName(Gateway $gateway)
	{
		$reflect = new ReflectionClass($gateway);
		$baseClass = $reflect->getShortName();
		$length = strlen($baseClass) - strlen('Gateway');

		return lcfirst( substr($baseClass, 0, $length) );
	}

	public function __call($method, $args)
	{
		$method = rtrim($method, 's');
		return $this->getGateway($method);
	}
}