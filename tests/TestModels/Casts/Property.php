<?php

namespace Yonchando\CastAttributes\Tests\TestModels\Casts;

use Yonchando\CastAttributes\CastAttributes;

class Property extends CastAttributes
{
    protected string $firstName;

    protected string $lastName;

    protected string $phoneNumber;

    protected ?string $gender;

    protected ?string $material;

    protected Image $image;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function getImage(): Image
    {
        return $this->image;
    }
}
