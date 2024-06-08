<?php

namespace Yonchando\CastAttributes;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes as BaseCastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Yonchando\CastAttributes\Traits\CastProperty;

class CastAttributes implements Arrayable, BaseCastsAttributes, Jsonable
{
    use CastProperty;

    public function get($model, string $key, $value, array $attributes): ?self
    {
        if (is_null($value)) {
            return null;
        }

        return self::create(json_decode($value));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof $this) {
            return json_encode($value->toArray());
        }

        return json_encode($value);
    }
}
