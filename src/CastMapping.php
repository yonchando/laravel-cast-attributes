<?php

namespace Yonchando\CastMapping;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Yonchando\CastMapping\Traits\Mappable;

abstract class CastMapping implements Arrayable, Jsonable, CastsAttributes
{
    use Mappable;

    public function get($model, string $key, $value, array $attributes): null|self
    {
        if (is_null($value)) {
            return null;
        }

        return new static(json_decode($value));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof $this) {
            return json_encode($this->toArray());
        }

        return json_encode($value);
    }
}
