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
    public function testItSuccessfullySubscribesATopic()
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

    /**
     * @test.
     *
     * @return void
     */
    public function testItSuccessfullyPublishesAMessage()
    {
        $response = $this->post('/api/publish/main', [
            [
                [
                    "name" => "John Doe",
                    "country" =>  "England"
                ]
            ]
        ]);

        $response
            ->assertStatus(202)
            ->assertJson([
                'topic' => 'main',
                'message' => [
                    [
                        "name" => "John Doe",
                        "country" =>  "England"
                    ]
                ]
            ]);
    }
}
