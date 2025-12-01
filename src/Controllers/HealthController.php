<?php

namespace Alexfc\Health\Controllers;

use Alexfc\Health\DTO\HealthDTO;
use Alexfc\Health\Services\HealthService;
use Alexfc\Health\Services\HealthServiceInterface;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{

    public function __construct(private HealthServiceInterface $healthService)
    {
    }

    public function check(): JsonResponse
    {
        $dbCheck = $this->healthService->checkDb();
        $redisCheck = $this->healthService->checkRedis();
        $commonStatus = HealthService::STATUS_HEALTHY;

        if ($dbCheck->status !== HealthService::STATUS_HEALTHY || $redisCheck->status !== HealthService::STATUS_HEALTHY) {
            $commonStatus = HealthService::STATUS_UNHEALTHY;
        }

        return new JsonResponse(
            new HealthDTO(
                [
                    'mysql' => $this->healthService->checkDb(),
                    'redis' => $this->healthService->checkRedis(),
                ],
                $commonStatus, Carbon::now(config('app.timezone'))->toIso8601String(),
            ),
        );
    }
}