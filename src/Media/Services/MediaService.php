<?php

namespace Modules\Media\Services;

use Illuminate\Http\UploadedFile;
use Modules\Media\Casts\File;

class MediaService
{
    public function store(UploadedFile $file, $type)
    {
        $path = $file->store('media', 'public');

        return new File($path.'?hash='.$this->makeHash($path, $type));
    }

    public function verify($securePath, $type)
    {
        try {
            list($path, $hash) = explode('?hash=', $securePath);

            return $hash === $this->makeHash($path, $type);
        } catch (\Exception $exception) {
            return false;
        }
    }

    protected function makeHash($path, $type)
    {
        $hash = hash_hmac('sha256', $path, $type);

        return substr($hash, 0, 8);
    }
}
