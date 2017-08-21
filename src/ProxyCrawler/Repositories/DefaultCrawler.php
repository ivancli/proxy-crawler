<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11/03/2017
 * Time: 3:48 PM
 */

namespace IvanCLI\ProxyCrawler\Repositories;


use IvanCLI\ProxyCrawler\Contracts\CrawlerContract;

abstract class DefaultCrawler implements CrawlerContract
{
    protected $url;
    protected $proxies = [];
    protected $content;
    protected $status;
    protected $headers = [
        'Accept-Language: en-us',
        'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.15) Gecko/20110303 Firefox/3.6.15',
        'Connection: Keep-Alive',
        'Cache-Control: no-cache',
    ];

    public function __construct()
    {
        $this->crawl();
        $this->fetch();
        $this->test();
    }

    /**
     * Get loaded IPs
     * @return mixed
     */
    public function getProxies()
    {
        return $this->proxies;
    }

    /**
     * Get request status code
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Update status property
     * @param $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * test crawled proxy ips
     * @return mixed
     */
    abstract public function test();

}