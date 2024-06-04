<?php

namespace Yonchando\CastMapping\Tests;

use PHPUnit\Framework\TestCase;
use Yonchando\CastMapping\Tests\TestModels\Property;

class CastMappingTest extends TestCase
{
    /** @test */
    public function it_can_setter_data_key_to_property_key_and_assign_value()
    {
        $gender = fake()->randomElement(['male', 'female']);

        $material = fake()->randomElement(['single', 'married', 'windows']);

        $property = new Property([
            'first_name' => "Chando",
            'last_name' => "Yon",
            'phone_number' => "092134563",
            'gender' => $gender,
            'material' => $material,
        ]);

        $this->assertEquals($gender, $property->getGender());
        $this->assertEquals($material, $property->getMaterial());
        $this->assertEquals("Chando", $property->getFirstName());
        $this->assertEquals("Yon", $property->getLastName());
        $this->assertEquals("092134563", $property->getPhoneNumber());
    }

    /** @test */
    public function it_can_setter_data_key_to_property_key_that_has_custom_type_class()
    {
        $property = new Property([
            'first_name' => "Chando",
            'last_name' => "Yon",
            'phone_number' => "092134563",
            "image" => [
                "filename" => "profile.png",
                "size" => 2,
                "path" => "images/profile.png",
            ]
        ]);

        $this->assertEquals("profile.png", $property->getImage()->getFilename());
    }

    /** @test */
    public function it_can_convert_all_property_to_array()
    {
        $data = [
            'first_name' => "Chando",
            'last_name' => "Yon",
            'phone_number' => "092134563",
            "image" => [
                "filename" => "profile.png",
                "size" => 2,
                "path" => "images/profile.png",
            ]
        ];

        $property = new Property($data);

        $expect = $property->toArray();

        $this->assertEquals($expect, $data);
    }
}
