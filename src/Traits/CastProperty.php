<?php

namespace Yonchando\CastAttributes\Traits;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

trait CastProperty
{
    public function __construct(array|object|null $data = null)
    {
        if (!is_null($data)) {
            $this->setReflectionProperties($data);
        }
    }

    public static function create(array|object|null $data = null): static
    {
        return new static($data);
    }

    private function setProperty(ReflectionProperty $property, $value): void
    {
        if ($property->isPrivate()) {
            throw new \InvalidArgumentException("Property '{$property->getName()}' must be accessible");
        }

        $propertyName = $property->getName();
        $this->$propertyName = $value;
    }

    private function getProperty(ReflectionProperty $property)
    {
        $propertyName = $property->getName();
        if ($property->isPrivate()) {
            return call_user_func_array([$this, 'get' . str($propertyName)->ucfirst()], []);
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

            $this->setPropertyValue($property, $value);
        }
    }

    private function setPropertyValue(ReflectionProperty $property, mixed $value): void
    {
        $isReflectionName = $property->getType() instanceof ReflectionNamedType;
        $isReflectionUnionType = $property->getType() instanceof ReflectionUnionType;
        
        if (is_null($property->getType()) || ($isReflectionName && $property->getType()->isBuiltin()) || $isReflectionUnionType) {
            $this->setProperty($property, $value);
        } else {
            if ($value instanceof \UnitEnum) {
                $buildClass = $value;
            } else {
                $buildClass = call_user_func_array([$property->getType()->getName(), 'create'], [$value]);
            }
            $this->setProperty($property, $buildClass);
        }
    }

    public function toArray(): array
    {
        $properties = [];

        foreach ($this->getReflectionProperties() as $property) {
            $propertyName = $property->getName();
            $propertyNameSnake = str($propertyName)->snake()->toString();
            
            $isReflectionName = $property->getType() instanceof ReflectionNamedType;
            $isReflectionUnionType = $property->getType() instanceof ReflectionUnionType;

            if (is_null($property->getType()) || ($isReflectionName && $property->getType()->isBuiltin()) || $isReflectionUnionType) {
                $properties[$propertyNameSnake] = $this->getProperty($property);
            } else {
                if ($property->getValue($this) instanceof \UnitEnum) {
                    $properties[$propertyNameSnake] = $property->getValue($this)->value;
                } else {
                    $properties[$propertyNameSnake] = $property->getValue($this)?->toArray();
                }
            }
        }

        return $properties;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

}
