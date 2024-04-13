<?php

namespace mrsatik\ServersTest;

use PHPUnit\Framework\TestCase;
use mrsatik\Servers\ServersCollection;
use mrsatik\Servers\ServerInterface;

class ServerItemTest extends TestCase
{
    /**
     * @dataProvider arrayHostPortParamsDataProvider
     */
    public function testServerGetItem(array $serverParams)
    {
        $serverString = '';
        $serverArray = [];
        foreach ($serverParams as $server) {
            $serverArray[] = $server['host'] . ':' . (string)$server['port'] . ':' . (string)$server['user'] . ':' . (string)$server['password'];
        }
        $serverString = implode(',', $serverArray);
        $serversCollection = new ServersCollection($serverString);
        /** @var ServerInterface $serverItem */
        foreach ($serversCollection as $k => $serverItem) {
            $this->assertSame($serverItem->getHost(), $serverParams[$k]['host']);

            if ($serverParams[$k]['port'] === null) {
                $this->assertNull($serverItem->getPort());
            } else {
                $this->assertSame($serverItem->getPort(), $serverParams[$k]['port']);
            }

            if ($serverParams[$k]['user'] === null) {
                $this->assertNull($serverItem->getUser());
            } else {
                $this->assertSame($serverItem->getUser(), $serverParams[$k]['user']);
            }

            if ($serverParams[$k]['password'] === null) {
                $this->assertNull($serverItem->getPassword());
            } else {
                $this->assertSame($serverItem->getPassword(), $serverParams[$k]['password']);
            }
        }
    }


    /**
     * @return array
     */
    public function arrayHostPortParamsDataProvider()
    {
        return [
            [
                [
                    [
                        'host' => 'foo',
                        'port' => 'bar',
                        'password' => null,
                        'user' => null,
                    ],
                    [
                        'host' => 'baaar',
                        'port' => 'foooo',
                        'user' => 'user',
                        'password' => 'test',
                    ],
                    [
                        'host' => 'fooo',
                        'port' => null,
                        'user' => null,
                        'password' => null,
                    ],
                ],
            ],
            [
                [
                    [
                        'host' => 'fooo',
                        'port' => null,
                        'user' => null,
                        'password' => null,
                    ],
                ],
            ],
            [
                [
                    [
                        'host' => 'baaar1',
                        'port' => 'foooo1',
                        'password' => 'test1',
                        'user' => 'user1',
                    ],
                    [
                        'host' => 'baaar2',
                        'port' => 'foooo2',
                        'password' => 'test2',
                        'user' => 'user2',
                    ],
                ],
            ],
        ];
    }
}