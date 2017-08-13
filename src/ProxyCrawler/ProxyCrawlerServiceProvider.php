<?php

/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11/03/2017
 * Time: 2:53 PM
 */

namespace IvanCLI\ProxyCrawler;

use Illuminate\Support\ServiceProvider;

class ProxyCrawlerServiceProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProxyCrawler();
    }

    private function registerProxyCrawler()
    {
        $this->app->bind(ProxyCrawler::class, function ($app) {
            return new ProxyCrawler($app);
        });

        $this->app->alias(ProxyCrawler::class, 'proxy-crawler');
    }
}