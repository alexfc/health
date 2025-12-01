<?php

namespace Alexfc\Health\DTO;

use JsonSerializable;

class HealthDTO implements JsonSerializable
{
    public string $status;
    public string $timestamp;

    public array $checks;

    /**
     * @param array $checks
     * @param string $status
     * @param string $timestamp
     */
    public function __construct(array $checks, string $status, string $timestamp)
    {
        $this->checks = $checks;
        $this->status = $status;
        $this->timestamp = $timestamp;
    }


    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'timestamp' => $this->timestamp,
            'checks' => $this->checks
        ];
    }
}