<?php

namespace App\DTOs;

use Illuminate\Support\Arr;

abstract class DataTransferObject
{
    public function __construct(array $data = [])
    {
        $this->fromArray($data);
    }

    /**
     * @param array $data
     * @return self
     */
    private function fromArray(array $data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && !blank($value)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }

    /**
     * @param array $except
     * @return array
     */
    public function toArray(array $except = []): array
    {
        return Arr::except(get_object_vars($this), $except);
    }

    /**
     * @param array $except
     * @return string
     */
    public function toJson(array $except = []): string
    {
        return json_encode($this->toArray($except));
    }

    /**
     * @param array $args
     * @return array<int, DataTransferObject>
     */
    public static function arrayOf(array $args): array
    {
        return array_map(fn ($data) => new static($data), $args);
    }
}
