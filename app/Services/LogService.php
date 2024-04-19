<?php

namespace App\Services;

use App\Models\Log;

class LogService
{
    public function createLog(?int $user_id, string $service, string $request_body, int $response_code): void
    {
        Log::create([
            'user_id' => $user_id,
            'service' => $service,
            'request_body' => $request_body,
            'response_code' => $response_code,
            'ip_address' => request()->getClientIp(),
        ]);
    }
}
