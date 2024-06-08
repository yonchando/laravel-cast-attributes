<?php

namespace Yonchando\CastAttributes\Traits;

use ReflectionClass;
use ReflectionProperty;

trait CastProperty
{
    public function __construct(array|object|null $data = null)
    {
        if (! is_null($data)) {
            $this->setReflectionProperties($data);
        }
    }

    public static function create(array|object|null $data = null): static
    {
        return new static($data);
    }

    private function setProperty(ReflectionProperty $property, $value): void
    {
        $propertyName = $property->getName();
        if ($property->isPrivate()) {
            call_user_func_array([$this, 'set'.str($propertyName)->ucfirst()], [$value]);
        } else {
            $this->$propertyName = $value;
        }
    }

    private function getProperty(ReflectionProperty $property)
    {
        $propertyName = $property->getName();
        if ($property->isPrivate()) {
            return call_user_func_array([$this, 'get'.str($propertyName)->ucfirst()], []);
        }

        return $property->getValue($this);
    }

    /**
     * @return array<ReflectionProperty>
     */
    private function getReflectionProperties(): array
    {
        $reflectionClass = new ReflectionClass($this);

        return $reflectionClass->getProperties();
    }

    private function setReflectionProperties(array|object $data): void
    {
        $reflectionProperties = $this->getReflectionProperties();

        foreach ($reflectionProperties as $property) {
            $propertyName = $property->getName();
            $value = data_get($data, str($propertyName)->snake()->toString());

            if (is_null($property->getType()) || $property->getType()->isBuiltin()) {
                $this->setProperty($property, $value);
            } else {
                $buildClass = call_user_func_array([$property->getType()->getName(), 'create'], [$value]);
                $this->setProperty($property, $buildClass);
            }
        }
    }

    public function toArray(): array
    {
        $properties = [];

        foreach ($this->getReflectionProperties() as $property) {
            $propertyName = $property->getName();
            if (is_null($property->getType()) || $property->getType()?->isBuiltin()) {
                $properties[str($propertyName)->snake()->toString()] = $this->getProperty($property);
            } else {
                $properties[str($propertyName)->snake()->toString()] = $property->getValue($this)->toArray();
            }
        }

        return $properties;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
