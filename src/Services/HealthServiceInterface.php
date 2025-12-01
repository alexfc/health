<?php

namespace Alexfc\Health\Services;

use Alexfc\Health\DTO\ServiceStatusDTO;

interface HealthServiceInterface
{
    public function checkDb(): ServiceStatusDTO;

    public function checkRedis(): ServiceStatusDTO;
}