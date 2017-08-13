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
    protected $ips = [];
    protected $content;
    protected $status;
    protected $headers = [
        'Accept-Language: en-us',
        'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.15) Gecko/20110303 Firefox/3.6.15',
        'Connection: Keep-Alive',
        'Cache-Control: no-cache',
    ];

    const PROXY_URL = 'http://www.freeproxylists.net/au.html';

    public function __construct()
    {
        $this->setURL(self::PROXY_URL);
        $this->crawl();
        $this->fetch();
    }

    /**
     * set target URL
     * @param $url
     * @return void
     */
    public function setURL($url)
    {
        $this->url = $url;
    }

    /**
     * Crawl web page content from given proxy provider
     * @return mixed
     */
    abstract public function crawl();

    /**
     * Load content
     * @return void
     */
    abstract public function fetch();

    /**
     * Get loaded IPs
     * @return mixed
     */
    public function getIps()
    {
        return $this->ips;
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
     * Update IPs property
     * @param $ips
     * @return void
     */
    public function setIps($ips)
    {
        $this->ips = $ips;
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
}