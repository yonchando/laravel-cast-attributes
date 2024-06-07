<?php

namespace Yonchando\CastAttributes\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Yonchando\CastAttributes\Tests\TestModels\Casts\Property;
use Yonchando\CastAttributes\Tests\TestModels\User;

class ModelTest extends TestCase
{
    /** @test */
    public function it_can_json_encode_property_array_to_store_in_database_when_use_casting()
    {
        $file = UploadedFile::fake()->image('fake.png', 1920, 1080);

        $properties = [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'gender' => fake()->randomElement(['male', 'female']),
            'material' => fake()->randomElement(['single', 'windowed', 'married']),
            'image' => [
                'filename' => $file->hashName(),
                'path' => '/images/'.$file->hashName(),
                'size' => $file->getSize(),
            ],
        ];

        $user = User::create([
            'properties' => $properties,
        ]);

        $this->assertDatabaseHas(User::class, [
            'properties' => json_encode($properties),
        ]);

        $this->assertEquals(Property::create($properties)->toJson(), $user->properties->toJson());
        $this->assertEquals(Property::create($properties)->toArray(), $user->properties->toArray());
    }

    /** @test */
    public function it_can_json_encode_property_class_to_store_in_database_when_use_casting()
    {
        $file = UploadedFile::fake()->image('fake.png', 1920, 1080);

        $properties = Property::create([
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'gender' => fake()->randomElement(['male', 'female']),
            'material' => fake()->randomElement(['single', 'windowed', 'married']),
            'image' => [
                'filename' => $file->hashName(),
                'path' => '/images/'.$file->hashName(),
                'size' => $file->getSize(),
            ],
        ]);

        $user = User::create([
            'properties' => $properties,
        ]);

        $this->assertDatabaseHas(User::class, [
            'properties' => $properties->toJson(),
        ]);

        $this->assertEquals($properties->toJson(), $user->properties->toJson());
        $this->assertEquals($properties->toArray(), $user->properties->toArray());
    }

    /** @test */
    public function it_can_access_custom_function_from_class_casting()
    {
        Storage::fake();

        $file = UploadedFile::fake()->image('fake.png', 1920, 1080);

        $properties = [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'gender' => fake()->randomElement(['male', 'female']),
            'material' => fake()->randomElement(['single', 'windowed', 'married']),
            'image' => [
                'filename' => $file->hashName(),
                'path' => '/images/'.$file->hashName(),
                'size' => $file->getSize(),
            ],
        ];

        $user = User::create([
            'properties' => $properties,
        ]);

        $this->assertEquals(Storage::url($properties['image']['path']), $user->properties->getImage()->url());
    }
}
