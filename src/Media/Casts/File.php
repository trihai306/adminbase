<?php

namespace Modules\Media\Casts;

use Illuminate\Support\Facades\Storage;

class File
{
    public $path;
    public $url;

    public function __construct($path)
    {
        $this->path = $path;

        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            $this->url = $this->path;
        } else if (!empty($this->path)) {
            $this->url = Storage::disk('public')->url($this->path);
        }
    }
}
