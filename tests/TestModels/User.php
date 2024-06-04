<?php

namespace Yonchando\CastMapping\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Property properties
 *
 * @mixin Model
 */
class User extends Model
{
    protected $table = 'users';

    protected $casts = [
        'properties' => Property::class
    ];
}
