<?php

namespace HttpServer\Test;

use HttpServer\HttpServer;
use Guzzle\Service\Client;

/**
 * Tests for the HttpServer.
 *
 * @see HttpServer\HttpServer
 */
class HttpServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @todo Find a way to dynamically find an open port.
     */
    private $port = 8090;
    private $addr = 'localhost';
    private $server;
    private $client;

    public function setUp() {
        // Set up a new web server with the project root as the document root.
        $root = dirname(dirname(dirname(__DIR__)));
        $this->server = new HttpServer($root, $this->addr, $this->port);
        $this->server->start();

        // Check to make sure the web server is still up after two seconds.
        sleep(2);

        // @todo Possibly move the port check over the HttpServer itself?
        if (!$this->server->isRunning()) {
            throw new \RuntimeException('Error opening server: ' . $this->server->getOutput() . $this->server->getErrorOutput());
        }

        // Make the client web requests as the server's root.
        $this->client = new Client($this->server->getAddr() . ':' . $this->server->getPort());
    }

    /**
     * Tests retrieving a response from the server.
     */
    public function testResponse()
    {
        // Get a response from the server and shut it down.
        $response = $this->getResponse('README.md');

        // Was there a correct response?
        $this->assertEquals(200, $response->getStatusCode(), 'ewtf');
    }

    public function tearDown() {
        if ($this->server) {
            // Shut down the server and allow time for the port to close.
            $this->server->stop();
            sleep(1);
        }
    }

    protected function getResponse($query) {
        return $this->client->get($query)->send();
    }
    
}
