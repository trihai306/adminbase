<?php

namespace Modules\Media\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Media\Services\MediaService;

class MediaFile implements Rule
{
    private $mediaService;
    private $type;

    public function __construct($type)
    {
        $this->mediaService = app(MediaService::class);
        $this->type = $type;
    }

    public function passes($attribute, $value)
    {
        return $this->mediaService->verify($value, $this->type);
    }

    public function message()
    {
        return trans('validation.media_file');
    }
}
