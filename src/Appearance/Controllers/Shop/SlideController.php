<?php

namespace Modules\Appearance\Controllers\Shop;

use Modules\Appearance\Repositories\SlideRepository;
use Modules\Appearance\Requests\Shop\IndexSlideRequest;
use Modules\Appearance\Transformers\SlideCollection;
use Modules\Appearance\Transformers\SlideResource;
use Modules\Core\Controllers\Controller;

class SlideController extends Controller
{
    private $slideRepository;

    public function __construct(SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
    }

    public function index(IndexSlideRequest $request)
    {
        $slides = $this->slideRepository->query(
            $request->validated()
        );

        return new SlideCollection($slides);
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $slide = $this->slideRepository->find($id) ?? $this->slideRepository->findByCode($id);
        } else {
            $slide = $this->slideRepository->findByCode($id);
        }

        $slide = $this->slideRepository->query([
            'id' => $slide->id
        ]);

        return new SlideResource($slide);
    }
}
