<?php

namespace Tests\Unit;

use Tests\TestCase;
use YiluTech\ApiDocGenerator\RouteParser;

class RouteParserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        require_once __DIR__ . '/../api.php';
    }

    public function testParseRoutes() {
        $parser = new RouteParser();

        dump($parser->parse());

        $this->assertTrue(true);
    }

}
