<?php namespace Viimed\PhpApi\Gateways;

use Mockery;

class EmrGatewayTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $gateway;

	protected function _before()
	{
		$http = $this->tester->makeHttp();
		$this->gateway = new EmrGateway($http);
	}

	protected function _after()
	{
		Mockery::close();
	}

	// tests
	public function testItImplementsEmrInterface()
	{
		$this->assertInstanceOf('Viimed\\PhpApi\\Interfaces\\EmrInterface', $this->gateway);
	}

	public function testFindById()
	{
		$route = 'api/v2/emrs/1';
		$params = [];
		$returnData = TRUE;

		$http = $this->tester->mockHttpWithRequest('GET', $route, $params, $returnData);
		
		$bool = (new EmrGateway($http))->findById(1);
		$this->assertTrue( $bool );
	}

}