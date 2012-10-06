<?php

/**
 * @file
 * Provides a wrapper around PHP 5.4's HTTP server.
 */

namespace HttpServer;

use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * An HTTP Server.
 *
 * @see HttpServer\Test\HttpServerTest
 */
class HttpServer extends PhpProcess
{
    private $addr;
    private $port;
    private $documentRoot;
    private $executableFinder;

    /**
     * Constructor.
     *
     * @param string $documentRoot The document root for the web server.
     *
     * @param string $addr The address hostname for the web server.
     *
     * @param int $port The port to open the web server on.
     */
    public function __construct($documentRoot = null, $addr = 'localhost', $port = 8080) {
        $this->executableFinder = new PhpExecutableFinder();
        $this->addr = $addr;
        $this->port = $port;
        $this->documentRoot = $documentRoot;
        parent::__construct('');
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
    }
    
    public function getAddr() {
        return $this->addr;
    }

    public function setAddr($addr) {
        $this->addr = $addr;
    }
    
    public function getDocumentRoot() {
        return $this->documentRoot;
    }

    public function setDocumentRoot($documentRoot) {
        $this->addr = $documentRoot;
    }

    /**
     * Starts the web server.
     *
     * @param callable $callback An output function to call whenever there is
     *     a log entry made to the server.
     */
    public function start($callback = null) {
        // Find the PHP executable.
        if (false === $php = $this->executableFinder->find()) {
            throw new \RuntimeException('Unable to find the PHP executable.');
        }

        $options = ' -S ' . $this->addr . ':' . $this->port;
        if (isset($this->documentRoot)) {
            $options .= ' -t ' . $this->documentRoot;
        }
        $this->setCommandLine($php . $options);
        parent::start($callback);
    }
}
