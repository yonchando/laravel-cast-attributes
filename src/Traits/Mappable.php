<?php

namespace Yonchando\CastMapping\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;

trait Mappable
{
    public function __construct(mixed $data = null)
    {
        if (!is_null($data)) {
            $this->setReflectionProperties($data);
        }
    }

    private function getReflectionProperties(): array
    {
        $reflectionClass = new ReflectionClass($this);

        return $reflectionClass->getProperties();
    }

    protected function setReflectionProperties(mixed $data): static
    {
        $reflectionProperties = $this->getReflectionProperties();
        foreach ($reflectionProperties as $property) {
            $this->value($property, $data);
        }

        return $this;
    }

    protected function setProperty($property, $value): void
    {
        $this->$property = $value;
    }

    protected function getProperty($property)
    {
        return $this->{$property};
    }

    protected function value(ReflectionProperty $property, mixed $data = null): array
    {

        $propertyName = $property->getName();

        if (!$property->isInitialized($this) && $property->getType()->isBuiltin()) {
            throw new InvalidArgumentException(
                "Property $propertyName with declare type need to be initial default value or assign value in constructor"
            );
        }

        $value = data_get($data, str($propertyName)->snake());

        if ($property->getType() && !$property->getType()?->isBuiltin()) {
            $className = $property->getType()->getName();
            $value = new $className($value);
        }

        if ($property->isPrivate()) {
            $methodName = "set" . str($propertyName)->ucfirst();

            if (!method_exists($this, $methodName)) {
                throw new InvalidArgumentException("Private $propertyName property need getter method");
            }

            return [$propertyName => call_user_func_array([$this, $methodName], [$value])];
        }

        return [$propertyName => $value];
    }

    public function toArray(): array
    {
        $properties = [];

        foreach ($this->getReflectionProperties() as $property) {
            $properties = [...$this->value($property), ...$properties];
        }

        return $properties;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
