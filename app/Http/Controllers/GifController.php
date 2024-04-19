<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchGifsRequest;
use App\Http\Requests\StoreGifRequest;
use App\Http\Resources\ApiResponse;
use App\Services\GiphyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GifController extends Controller
{
    private GiphyService $giphyService;

    public function __construct(GiphyService $giphyService)
    {
        $this->giphyService = $giphyService;
    }

    public function search(SearchGifsRequest $request): JsonResponse
    {
        try {
            $query = $request->input('query', '');
            $limit = $request->input('limit', 25);
            $offset = $request->input('offset', 0);

            $results = $this->giphyService->getGifs($query, $limit, $offset);
            return (new ApiResponse([
                'data' => $results,
                'message' => 'GIFs retrieved successfully'
            ]))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            Log::error("Error searching GIFs: " . $e->getMessage());
            return (new ApiResponse([
                'message' => 'Failed to retrieve GIFs',
                'data' => [],
                'code' => 500
            ]))->response()->setStatusCode(500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $result = $this->giphyService->getGifById($id);
            return (new ApiResponse([
                'data' => $result,
                'message' => 'GIF retrieved successfully'
            ]))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            Log::error("Error retrieving GIF by ID: " . $e->getMessage());
            return (new ApiResponse([
                'message' => 'Failed to retrieve GIF',
                'data' => [],
                'code' => 500
            ]))->response()->setStatusCode(500);
        }
    }

    public function store(StoreGifRequest $request): JsonResponse
    {
        try {
            $user_id = $request->input('user_id');
            $gif_id = $request->input('gif_id');
            $alias = $request->input('alias');

            $favorite = $this->giphyService->store($user_id, $gif_id, $alias);
            return (new ApiResponse([
                'data' => $favorite,
                'message' => 'Favorite GIF saved successfully'
            ]))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            Log::error("Error saving favorite GIF: " . $e->getMessage());
            return (new ApiResponse([
                'message' => 'Failed to save favorite GIF',
                'data' => [],
                'code' => 500
            ]))->response()->setStatusCode(500);
        }
    }
}
