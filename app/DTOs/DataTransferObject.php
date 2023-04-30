<?php

namespace App\DTOs;

use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionProperty;

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
    protected function fromArray(array $data): self
    {
        $reflectionClass = new ReflectionClass(static::class);
        $attributesPublic = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($attributesPublic as $attribute) {
            $value = Arr::get($data, $attribute->getName());

            if ($this->isDTO($attribute->getType()->getName())) {
                $className = $attribute->getType()->getName();
                $value = new $className($value);
            }

            $this->{$attribute->getName()} = $value;
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
     * @param string $attributeType
     * @return boolean
     */
    protected function isDTO(string $attributeType): bool
    {
        return class_exists($attributeType) && new $attributeType instanceof self;
    }

    /**
     * @param array $args
     * @return array<int, DataTransferObject>
     */
    public static function arrayOf(array $args): array
    {
        return array_map(
            fn ($data) => new static($data),
            $args
        );
    }
}
