<?php

namespace Tests\Ploi\Resources;

use Tests\BaseTest;
use Ploi\Http\Response;
use Ploi\Resources\Server\Server;
use Ploi\Exceptions\Resource\RequiresId;

/**
 * Class ServerTest
 *
 * @package Tests\Ploi\Resources
 */
class ServerTest extends BaseTest
{
    public function testInstanceOfServer()
    {
        $this->assertInstanceOf(Server::class, $this->getPloi()->server());
    }

    /**
     * @throws \Ploi\Exceptions\Http\InternalServerError
     * @throws \Ploi\Exceptions\Http\NotFound
     * @throws \Ploi\Exceptions\Http\NotValid
     * @throws \Ploi\Exceptions\Http\PerformingMaintenance
     * @throws \Ploi\Exceptions\Http\TooManyAttempts
     */
    public function testGetAllServers()
    {
        $servers = $this->getPloi()
                        ->server()
                        ->get();

        // Test that it's a valid response object
        $this->assertInstanceOf(Response::class, $servers);

        // Test the json object response
        $this->assertInstanceOf(\stdClass::class, $servers->getJson());

        // Test the array response
        $this->assertInternalType('array', $servers->toArray());

        // Test to make sure that the data is an array
        $this->assertInternalType('array', $servers->getJson()->data);
    }

    /**
     * @throws \Ploi\Exceptions\Http\InternalServerError
     * @throws \Ploi\Exceptions\Http\NotFound
     * @throws \Ploi\Exceptions\Http\NotValid
     * @throws \Ploi\Exceptions\Http\PerformingMaintenance
     * @throws \Ploi\Exceptions\Http\TooManyAttempts
     */
    public function testGetSingleServer()
    {
        $serverResource = $this->getPloi()
                               ->server();

        // Get all servers and select the first one
        $allServers = $serverResource->get();
        $firstServer = $allServers->getJson()->data[0];

        if (!empty($firstServer)) {
            $serverId = $firstServer->id;

            // Get a single server through a pre-existing server resource
            $methodOne = $serverResource->get($serverId);

            // Get a single server through a new server resource
            $methodTwo = $this->getPloi()->server($serverId)->get();

            $this->assertEquals($serverId, $methodOne->getJson()->data->id);
            $this->assertEquals($serverId, $methodTwo->getJson()->data->id);
        }

        // Check that it throws a RequiresId error
        try {
            $this->getPloi()->server()->get();
        } catch (\Exception $exception) {
            $this->assertInstanceOf(RequiresId::class, $exception);
        }
    }

    /**
     * @throws \Ploi\Exceptions\Http\InternalServerError
     * @throws \Ploi\Exceptions\Http\NotFound
     * @throws \Ploi\Exceptions\Http\NotValid
     * @throws \Ploi\Exceptions\Http\PerformingMaintenance
     * @throws \Ploi\Exceptions\Http\TooManyAttempts
     * @throws \Ploi\Exceptions\Resource\RequiresId
     */
    public function testGetServerLogs()
    {
        $serverResource = $this->getPloi()
                               ->server();

        // Get all servers and select the first one
        $allServers = $serverResource->get();
        $firstServer = $allServers->getJson()->data[0];

        if (!empty($firstServer)) {
            $serverId = $firstServer->id;

            // Get a single server through a pre-existing server resource
            $methodOne = $serverResource->logs($serverId);

            // Get a single server through a new server resource
            $methodTwo = $this->getPloi()->server($serverId)->logs();

            $this->assertInternalType('array', $methodOne->getJson()->data);
            $this->assertEquals($serverId, $methodOne->getJson()->data[0]->server_id);
            $this->assertEquals($serverId, $methodTwo->getJson()->data[0]->server_id);
        }

        // Check that it throws a RequiresId error
        try {
            $this->getPloi()->server()->logs();
        } catch (\Exception $exception) {
            $this->assertInstanceOf(RequiresId::class, $exception);
        }
    }
}
