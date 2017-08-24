<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 12/08/2017
 * Time: 11:56 PM
 */

namespace IvanCLI\ProxyCrawler\Repositories;


use Ixudra\Curl\Facades\Curl;
use Symfony\Component\DomCrawler\Crawler;

class IdCloak extends DefaultCrawler
{
    protected $url = 'http://www.idcloak.com/proxylist/australia-proxy-list.html';

    const ROW_XPATH = '//*[@class="proxy_table"]//tr[descendant::td[text()="High"]]';

    const PORT_XPATH = '//td[last()-1]';
    const IP_XPATH = '//td[last()]';

    const WAIT_TIMEOUT = 3;

    /**
     * Crawl web page content from given proxy provider
     * @return mixed
     */
    public function crawl()
    {
        $response = Curl::to($this->url)
            ->withHeaders($this->headers)
            ->returnResponseObject()
            ->withOption("FOLLOWLOCATION", true)
            ->withOption("HEADER", true)
            ->get();

        $this->setStatus($response->status);

        if ($response->status === 200) {
            $this->content = $response->content;
        }
    }

    /**
     * Load content
     * @return void
     */
    public function fetch()
    {
        if (!is_null($this->content)) {
            $crawler = new Crawler($this->content);
            $rowNodes = $crawler->filterXPath(self::ROW_XPATH);
            $rowNodes->each(function (Crawler $rowNode) {
                $port = null;
                $ip = null;
                #region port
                $portNodes = $rowNode->filterXPath(self::PORT_XPATH);
                if ($portNodes->count() > 0) {
                    $port = $portNodes->first()->text();
                }
                #endregion

                #region ip
                $ipNodes = $rowNode->filterXPath(self::IP_XPATH);
                if ($ipNodes->count() > 0) {
                    $ip = $ipNodes->first()->text();
                }
                #endregion
                if (!is_null($port) && !is_null($ip)) {
                    $proxy = new \stdClass();
                    $proxy->ip = $ip;
                    $proxy->port = $port;
                    $this->proxies[] = $proxy;
                }
            });
        }
    }

    /**
     * Test crawled proxy ips
     */
    public function test()
    {
        foreach ($this->proxies as $index => $proxy) {
            if (@fsockopen($proxy->ip, $proxy->port, $errCode, $errStr, self::WAIT_TIMEOUT) === false) {
                $this->proxies = array_splice($this->proxies, $index, 1);
            }
        }
    }
}