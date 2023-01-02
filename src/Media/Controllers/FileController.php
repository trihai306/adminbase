<?php

namespace Modules\Media\Controllers;

use Modules\Core\Controllers\Controller;
use Modules\Media\Requests\StoreFileRequest;
use Modules\Media\Services\MediaService;
use Modules\Media\Transformers\FileResource;

class FileController extends Controller
{
    private $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function store(StoreFileRequest $request)
    {
        $mediaFile = $this->mediaService->store(
            $request->file('file'),
            $request->input('type')
        );

        return new FileResource($mediaFile);
    }
}
