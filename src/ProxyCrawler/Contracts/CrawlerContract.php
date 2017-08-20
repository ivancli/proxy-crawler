<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11/03/2017
 * Time: 3:23 PM
 */

namespace IvanCLI\ProxyCrawler\Contracts;


use Ixudra\Curl\Facades\Curl;

interface CrawlerContract
{
    /**
     * Crawl web page content from given proxy provider
     * @return mixed
     */
    public function crawl();

    /**
     * Load content
     * @return mixed
     */
    public function fetch();

    /**
     * Get loaded Proxies
     * @return mixed
     */
    public function getProxies();

    /**
     * Get request status code
     * @return mixed
     */
    public function getStatus();

    /**
     * Update status property
     * @param $status
     * @return void
     */
    public function setStatus($status);
}