<?php

namespace LaravelExportConstants\Tests;

use Illuminate\Support\Facades\Cache;
use LaravelExportConstants\LaravelExportConstants;
use LaravelExportConstants\LaravelExportConstantsServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    #[\LaravelExportConstants\Attributes\ExportToJs]
    public const TEST_CONSTANT = 'test value';
    #[\LaravelExportConstants\Attributes\ExportToJs]
    public const OTHER_TEST_CONSTANT = 'other test value';

    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('laravelExportConstants');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelExportConstantsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $this->app = $app;
        // Setup default database to use sqlite :memory:
        $app['config']->set('export-constants.namespaces', ['LaravelExportConstants\Tests']);
        $app['config']->set('cache.driver', 'array');
    }

    protected function usesLaravelNamespace($app): void
    {
        $app->config->set('export-constants.namespaces', ['Illuminate']);
    }

    /**
     * @test
     */
    public function it_registers(): void
    {
        $json = $this->app->make(LaravelExportConstants::class)->generate();
        $this->assertStringContainsString(self::TEST_CONSTANT, $json);
    }

    /**
     * @test
     * @define-env usesLaravelNamespace
     */
    public function it_finds_nothing(): void
    {
        $json = $this->app->make(LaravelExportConstants::class)->generate();
        $this->assertStringContainsString(self::TEST_CONSTANT, $json);
    }
}
