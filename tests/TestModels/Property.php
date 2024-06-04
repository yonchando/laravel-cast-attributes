<?php

namespace Yonchando\CastMapping\Tests\TestModels;

use Yonchando\CastMapping\CastMapping;
use Yonchando\CastMapping\GetterSetter;

class Property extends CastMapping implements GetterSetter
{

    private string $firstName = "";
    private string $lastName = "";
    private string $phoneNumber = "";
    private ?string $gender = "";
    private ?string $material = "";
    private Image $image;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getMaterial(): string
    {
        return $this->material;
    }

    public function setMaterial(?string $material): void
    {
        $this->material = $material;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function setImage(Image $image): void
    {
        $this->image = $image;
    }
}
