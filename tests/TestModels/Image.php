<?php

namespace Yonchando\CastMapping\Tests\TestModels;

use Yonchando\CastMapping\Traits\Mappable;

class Image
{
    use Mappable;

    private string $filename = "";
    private string $path = "";
    private int $size = 0;

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}
