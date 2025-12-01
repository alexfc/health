<?php

namespace Alexfc\Health\Services;

use Alexfc\Health\DTO\ServiceStatusDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HealthService implements HealthServiceInterface
{
    const STATUS_HEALTHY = 'healthy';
    const STATUS_UNHEALTHY = 'unhealthy';

    public function checkDb(): ServiceStatusDTO
    {
        $start = microtime(true);

        try {
            DB::select('SELECT 1');
        } catch (\Throwable $e) {
            $end = microtime(true);

            return new ServiceStatusDTO($e->getMessage(), round(($end - $start), 4)  * 1000, self::STATUS_UNHEALTHY);
        }

        $end = microtime(true);

        return new ServiceStatusDTO(null, round(($end - $start), 4)  * 1000, self::STATUS_HEALTHY);
    }

    public function checkRedis(): ServiceStatusDTO
    {
        $start = microtime(true);

        try {
            $response = Redis::ping();

            if (true !== $response) {
                throw new \RuntimeException('Unexpected Redis response: ' . $response);
            }
        } catch (\Throwable $e) {
            $end = microtime(true);

            return new ServiceStatusDTO(
                $e->getMessage(),
                round(($end - $start), 4)  * 1000,
                self::STATUS_UNHEALTHY
            );
        }

        $end = microtime(true);

        return new ServiceStatusDTO(
            null,
            round(($end - $start), 4)  * 1000,
            self::STATUS_HEALTHY
        );
    }
}
