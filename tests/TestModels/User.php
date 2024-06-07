<?php

namespace Yonchando\CastAttributes\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Yonchando\CastAttributes\Tests\TestModels\Casts\Property;

/**
 * @property Property properties
 *
 * @mixin Model
 */
class User extends Model
{
    protected $table = 'users';

    protected $guarded = [];

    protected $casts = [
        'properties' => Property::class,
    ];
}
