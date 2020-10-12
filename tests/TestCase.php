<?php

namespace Gentor\LaravelOneSky\Tests;

use Gentor\LaravelOneSky\ServiceProvider;
use Gentor\LaravelOneSky\Tests\Support\Client;
use Dotenv\Dotenv;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();
        $baseDir = dirname(dirname(__FILE__));
        if (is_readable($baseDir . '/.env')) {
            (new Dotenv($baseDir))->load();
        }
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->singleton('onesky', function () {
            return new Client();
        });

        $onesky = require __DIR__ . '/../config/onesky.php';
        $onesky['translations_path'] = __DIR__ . '/stubs/lang';
        $app['config']['onesky'] = $onesky;

        $app->register(ServiceProvider::class, [], true);
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
