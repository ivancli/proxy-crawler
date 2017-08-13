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

class FreeProxy extends DefaultCrawler
{
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
        $crawler = new Crawler($this->content);
        fwrite(STDERR, print_r($this->content));
    }
}