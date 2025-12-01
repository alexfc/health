<?php

namespace Alexfc\Health\DTO;

use JsonSerializable;

class ServiceStatusDTO implements JsonSerializable
{
    public string $status;

    public ?string $latencyMs;

    public ?string $error;

    /**
     * @param ?string $error
     * @param ?string $latencyMs
     * @param string $status
     */
    public function __construct(?string $error, ?string $latencyMs, string $status)
    {
        $this->error = $error;
        $this->latencyMs = $latencyMs;
        $this->status = $status;
    }

    public function jsonSerialize():  array
    {
        $result = [
            'status' => $this->status,
            'latency_ms' => $this->latencyMs
        ];

        if ($this->error) {
            $result = array_merge($result, ['error' => $this->error]);
        }

        return $result;
    }
}
