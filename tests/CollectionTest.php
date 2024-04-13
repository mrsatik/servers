<?php

namespace mrsatik\ServersTest;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use mrsatik\Servers\ServersCollection;

class CollectionTest extends TestCase
{
    public function testServerGetExceptionNull()
    {
        $this->expectException(InvalidArgumentException::class);
        $serversCollection = new ServersCollection(null);
    }

    public function testServerGetExceptionEmptyString()
    {
        $this->expectException(InvalidArgumentException::class);
        $serversCollection = new ServersCollection('');
    }

    public function testServersCollectionInit()
    {
        $serversCollection = new ServersCollection('test');
        $this->assertCount(0, $serversCollection);

        $serversCollection = new ServersCollection('test:test');
        $this->assertCount(0, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar:');
        $this->assertCount(1, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar:,fooo:baaar:test');
        $this->assertCount(2, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar:,:baaar:test');
        $this->assertCount(1, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar:,:baaar:test,fooo:baaar:test');
        $this->assertCount(2, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar::,:baaar:test:,fooo:baaar:test:pass');
        $this->assertCount(2, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar::,:baaar:test:');
        $this->assertCount(1, $serversCollection);

        $serversCollection = new ServersCollection('foo:bar::');
        $this->assertCount(1, $serversCollection);
    }
}