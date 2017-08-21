<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 21/08/2017
 * Time: 10:29 PM
 */

namespace IvanCLI\Tests\Feature;


use IvanCLI\ProxyCrawler\Repositories\XRoxy;
use Ixudra\Curl\CurlServiceProvider;
use Laravel\Lumen\Application;
use PHPUnit\Framework\TestCase;

class XRoxyTest extends TestCase
{
    const WAIT_TIMEOUT = 3;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->__buildApp();
        parent::__construct($name, $data, $dataName);
    }

    public function testXRoxyCrawlTest()
    {
        $idCloak = new XRoxy();

        $proxies = $idCloak->getProxies();
        $this->assertTrue(is_array($proxies) && count($proxies) > 0);
    }

    public function testCrawledProxies()
    {
        $idCloak = new XRoxy();

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