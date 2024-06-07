<?php

namespace Yonchando\CastAttributes\Tests\TestModels\Casts;

use Yonchando\CastAttributes\Traits\CastProperty;

class Image
{
    use CastProperty;

    private string $filename = '';

    private string $path = '';

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

    public function url()
    {
        return \Storage::url($this->path);
    }
}
