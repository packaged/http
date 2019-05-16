<?php
namespace Packaged\Tests\Http;

use Packaged\Http\Response;
use PHPUnit\Framework\TestCase;
use function microtime;

class ResponseTest extends TestCase
{
  public function testExtendsSymfonyResponse()
  {
    $response = new Response();
    $this->assertInstanceOf(
      '\Symfony\Component\HttpFoundation\Response',
      $response
    );
  }

  public function testSend()
  {
    $response = new Response();
    $responseSend = $response->send();
    $this->assertObjectHasAttribute('headers', $responseSend);
    $this->assertObjectHasAttribute('content', $responseSend);
    $this->assertObjectHasAttribute('version', $responseSend);
    $this->assertObjectHasAttribute('statusCode', $responseSend);
    $this->assertObjectHasAttribute('statusText', $responseSend);
    $this->assertObjectHasAttribute('charset', $responseSend);
  }

  public function testStatusText()
  {
    $response = Response::create('', 500);
    $this->assertStringContainsString('Internal Server Error', $response->getStatusText());
  }

  public function testDebugHeaders()
  {
    if(!defined('PHP_START'))
    {
      define('PHP_START', microtime(true));
    }
    $response = new Response();
    $response->enableDebugHeaders();
    $response->setDebugHeaders();
    $this->assertStringContainsString('X-Execution-Time', (string)$response);

    $response = new Response();
    $response->disableDebugHeaders();
    $response->enableDebugHeaders();
    $response->disableDebugHeaders();
    $response->setDebugHeaders();
    $this->assertStringNotContainsString('X-Execution-Time', (string)$response);

    $response = new Response();
    $response->disableDebugHeaders();
    $response->enableDebugHeaders();
    $response->setDebugHeaders();
    $this->assertStringContainsString('X-Execution-Time', (string)$response);

    $response = new Response();
    $response->setCallStartTime(microtime(true));
    $response->enableDebugHeaders();
    $response->setDebugHeaders();
    $this->assertStringContainsString('X-Execution-Time', (string)$response);
    $this->assertStringContainsString('X-Call-Time', (string)$response);
  }
}
