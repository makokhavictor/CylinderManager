<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function redis_running()
    {
        $app = Redis::connection();
        $app->set('test', 'testValue');
        $this->assertTrue($app->get('test') === 'testValue');
    }
}
