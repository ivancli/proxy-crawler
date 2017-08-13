<?php

/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 13/08/2017
 * Time: 12:37 AM
 */

namespace IvanCLI\Tests\Feature;

use IvanCLI\ProxyCrawler\Repositories\FreeProxy;
use Ixudra\Curl\Facades\Curl;
use PHPUnit\Framework\TestCase;

class FreeProxyTest extends TestCase
{
    /**
     * @param $app
     */
    public function testFreeProxyCrawlTest()
    {
        $freeProxy = new FreeProxy();
    }
}