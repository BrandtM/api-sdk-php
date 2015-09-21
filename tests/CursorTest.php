<?php

namespace Hitmeister\Component\Api\Tests;

use Hitmeister\Component\Api\Cursor;

class CursorTest extends TransportAwareTestCase
{
	/** @var \Mockery\Mock|\Hitmeister\Component\Api\Endpoints\AbstractEndpoint */
	private $endpoint;

	/**
	 *
	 */
	public function setUp()
	{
		parent::setUp();

		// Partial mock of abstract class
		$this->endpoint =
			\Mockery::mock('\Hitmeister\Component\Api\Endpoints\AbstractEndpoint[getParamWhiteList,getMethod,getURI]',
				[$this->transport]);
		$this->endpoint->shouldReceive('getParamWhiteList')->andReturn(['limit', 'offset']);
		$this->endpoint->shouldReceive('getMethod')->andReturn('GET');
		$this->endpoint->shouldReceive('getURI')->andReturn('categories/');
	}

	/**
	 * This method is called after a test is executed.
	 */
	public function tearDown()
	{
		$this->endpoint = null;
		parent::tearDown();
	}

	public function testIterate()
	{
		// First request
		$this->transport
			->shouldReceive('performRequest')
			->once()
			->withArgs([
				'GET',
				'categories/',
				['limit' => 100, 'offset' => 2],
				\Mockery::any(),
				\Mockery::any()
			])->andReturn([
				'headers' => [
					'Hm-Collection-Range' => ['3-102/5575'],
				],
				'json' => array_fill(0, 100, ['id_category' => 1])
			]);

		// Second request
		$this->transport
			->shouldReceive('performRequest')
			->once()
			->withArgs([
				'GET',
				'categories/',
				['limit' => 2, 'offset' => 102],
				\Mockery::any(),
				\Mockery::any()
			])->andReturn([
				'headers' => [
					'Hm-Collection-Range' => ['103-104/5575'],
				],
				'json' => array_fill(0, 2, ['id_category' => 1])
			]);
		$this->endpoint->setParams(['offset' => 2, 'limit' => 102]);

		$cursor = new Cursor($this->endpoint, '\Hitmeister\Component\Api\Transfers\CategoryTransfer');
		$this->assertInstanceOf('\Hitmeister\Component\Api\Endpoints\AbstractEndpoint', $cursor->getEndpoint());

		$count = 0;
		foreach ($cursor as $i => $item) {
			$this->assertEquals($count, $i);
			$this->assertInstanceOf('\Hitmeister\Component\Api\Transfers\CategoryTransfer', $item);
			$count++;
		}

		$this->assertEquals(102, $count);

		// Iterate again (should not call performRequest)
		$count = 0;
		foreach ($cursor as $i => $item) {
			$count++;
		}
		$this->assertEquals(102, $count);

		// Try to iterate by hand
		$cursor->rewind();
		while($item = $cursor->current()) {
			$cursor->next();
		}

		// Ask more
		$cursor->next();
		$this->assertNull($cursor->current());
	}
}