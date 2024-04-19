<?php

namespace Tests\Unit;

use App\Services\LogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\GiphyService;
use Illuminate\Support\Facades\Http;

class GiphyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpPassportClients();
        $this->logServiceMock = \Mockery::mock(LogService::class)->makePartial();
    }

    public function test_get_gifs_returns_correct_data()
    {
        $this->logServiceMock->shouldReceive('createLog')->once();

        Http::fake([
            'api.giphy.com/v1/gifs/search*' => Http::response(['data' => 'fake_data'], 200),
        ]);

        $service = new GiphyService($this->logServiceMock, 'api_key');
        $response = $service->getGifs('test', 10, 0);

        $this->assertEquals(['data' => 'fake_data'], $response);
    }

    public function test_get_gif_by_id_returns_correct_data()
    {
        $this->logServiceMock->shouldReceive('createLog')->once();

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response(['data' => 'fake_gif_data'], 200),
        ]);

        $service = new GiphyService($this->logServiceMock, 'api_key');
        $response = $service->getGifById('123');

        $this->assertEquals(['data' => 'fake_gif_data'], $response);
    }
}
