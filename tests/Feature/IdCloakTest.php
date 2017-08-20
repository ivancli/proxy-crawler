<?php

/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 13/08/2017
 * Time: 12:37 AM
 */

namespace IvanCLI\Tests\Feature;

use IvanCLI\ProxyCrawler\Repositories\IdCloak;
use Ixudra\Curl\CurlServiceProvider;
use Ixudra\Curl\Facades\Curl;
use Laravel\Lumen\Application;
use PHPUnit\Framework\TestCase;

class IdCloakTest extends TestCase
{
    const WAIT_TIMEOUT = 3;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->__buildApp();
        parent::__construct($name, $data, $dataName);
    }

    public function testIdCloakCrawlTest()
    {
        $idCloak = new IdCloak();

        $proxies = $idCloak->getProxies();
        $this->assertTrue(is_array($proxies) && count($proxies) > 0);
    }

    public function testCrawledProxies()
    {
        $idCloak = new IdCloak();

        $proxies = $idCloak->getProxies();
        foreach ($proxies as $proxy) {
            $this->assertTrue(@fsockopen($proxy->ip, $proxy->port, $errCode, $errStr, self::WAIT_TIMEOUT) !== false);
        }
    }

    private function __buildApp()
    {
        $app = new Application();
        $app->singleton(
            Illuminate\Contracts\Debug\ExceptionHandler::class,
            App\Exceptions\Handler::class
        );

        $app->singleton(
            Illuminate\Contracts\Console\Kernel::class,
            App\Console\Kernel::class
        );
        $app->withFacades();
        $app->register(CurlServiceProvider::class);
    }
}