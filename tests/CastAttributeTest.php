<?php

namespace Yonchando\CastAttributes\Tests;

use PHPUnit\Framework\TestCase;
use Yonchando\CastAttributes\Tests\TestModels\Casts\Image;
use Yonchando\CastAttributes\Tests\TestModels\Casts\Property;

class CastAttributeTest extends TestCase
{
    /** @test */
    public function it_can_setter_data_key_to_property_key_and_assign_value()
    {
        $gender = fake()->randomElement(['male', 'female']);

        $material = fake()->randomElement(['single', 'married', 'windows']);

        $property = new Property([
            'first_name' => 'Chando',
            'last_name' => 'Yon',
            'phone_number' => '092134563',
            'gender' => $gender,
            'material' => $material,
        ]);

        $this->assertEquals($gender, $property->getGender());
        $this->assertEquals($material, $property->getMaterial());
        $this->assertEquals('Chando', $property->getFirstName());
        $this->assertEquals('Yon', $property->getLastName());
        $this->assertEquals('092134563', $property->getPhoneNumber());
    }

    /** @test */
    public function it_can_setter_data_key_to_property_key_that_has_custom_type_class()
    {
        $image = [
            'filename' => 'profile.png',
            'size' => 2,
            'path' => 'images/profile.png',
        ];
        $property = new Property([
            'first_name' => 'Chando',
            'last_name' => 'Yon',
            'phone_number' => '092134563',
            'image' => $image,
        ]);

        $this->assertEquals(new Image($image), $property->getImage());
    }

    /** @test */
    public function it_can_convert_all_property_to_array()
    {
        $data = [
            'first_name' => 'Chando',
            'last_name' => 'Yon',
            'phone_number' => '092134563',
            'image' => [
                'filename' => 'profile.png',
                'size' => 2,
                'path' => 'images/profile.png',
            ],
            'gender' => null,
            'material' => null,
        ];

        $property = new Property($data);

        $expect = $property->toArray();

        $this->assertEquals($expect, $data);
    }
}
