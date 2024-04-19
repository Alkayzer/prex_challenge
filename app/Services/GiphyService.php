<?php

namespace App\Services;

use App\Models\Gif;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GiphyService
{

    private LogService $logService;
    protected string $baseUrl = 'https://api.giphy.com/v1/gifs';
    protected string $apiKey;

    public function __construct(LogService $logService, string $apiKey)
    {
        $this->logService = $logService;
        $this->apiKey = $apiKey;
    }

    public function getGifs(string $query, int $limit = 25, int $offset = 0): ?array
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'api_key' => $this->apiKey,
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        $this->logService->createLog(
            auth()->id(),
            'gifService.getGifs',
            json_encode(['q' => $query, 'limit' => $limit, 'offset' => $offset]),
            $response->status());

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Failed to retrieve GIFs: ' . $response->body());
        return null;
    }

    public function getGifById(string $id): ?array
    {
        $response = Http::get("{$this->baseUrl}/$id", [
            'api_key' => $this->apiKey,
        ]);

        $this->logService->createLog(
            auth()->id(),
            'gifService.getGifById',
            json_encode(['id' => $id]),
            $response->status());


        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Failed to retrieve GIF by ID: ' . $response->body());
        return null;
    }

    public function store(int $userId, string $gifId, string $alias): Gif
    {
        $gif = new Gif([
            'user_id' => $userId,
            'gif_id' => $gifId,
            'alias' => $alias
        ]);
        $gif->save();

        $this->logService->createLog(
            auth()->id(),
            'gifService.store',
            json_encode(['user_id' => $userId, 'gif_id' => $gifId, 'alias' => $alias]),
            200
        );

        return $gif;
    }

}
