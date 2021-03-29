<?php

namespace Tests\Unit;

use Tests\TestCase;

class SubscriberTest extends TestCase
{

    /**
     * @test.
     *
     * @return void
     */
    public function testItHasASubscriberUrlInTheBody()
    {
        $response = $this->post('/api/subscribe/main', []);
        $response
            ->assertStatus(412);
    }

    /**
     * @test.
     *
     * @return void
     */
    public function testItSuccessfullyCreatesASubscription()
    {
        $response = $this->post('/api/subscribe/main', [
            'url' => 'http://localhost:8080'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'url' => 'http://localhost:8080',
                'topic' => 'main'
            ]);
    }

}
