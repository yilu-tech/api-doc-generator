<?php

namespace Tests\Unit;

use Tests\TestCase;
use YiluTech\ApiDocGenerator\ApiDocGenerator;
use YiluTech\ApiDocGenerator\ApiDocGeneratorServiceProvider;

class RouteParserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        require_once __DIR__ . '/../api.php';
    }

    protected function getPackageProviders($app)
    {
        return [ApiDocGeneratorServiceProvider::class];
    }

    public function testFormRequest()
    {
        $response = $this->postJson('/user/create');
        $response->assertStatus(422);
    }

    public function testPublishConfig()
    {
        $this->artisan('vendor:publish --tag=api-doc-config')->run();
        $this->assertTrue(true);
    }

    public function testGenerateYaml()
    {
        $this->artisan('api-doc:generate --yaml')->run();
        $this->assertTrue(true);
    }

    public function testGenerateJson()
    {
        $this->artisan('api-doc:generate --json')->run();
        $this->assertTrue(true);
    }

    public function testParseRoutes()
    {
        $parser = new ApiDocGenerator();
        $this->assertNotEmpty($parser->toArray()['paths']);
    }
}
