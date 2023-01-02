<?php

namespace Modules\Appearance\Controllers\Admin;

use Modules\Appearance\Repositories\SlideRepository;
use Modules\Appearance\Requests\Admin\IndexSlideRequest;
use Modules\Appearance\Requests\Admin\StoreSlideRequest;
use Modules\Appearance\Requests\Admin\UpdateSlideRequest;
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

    public function store(StoreSlideRequest $request)
    {
        $slide = $this->slideRepository->create(
            $request->validated()
        );

        $slide = $this->slideRepository->query([
            'id' => $slide->id
        ]);

        return new SlideResource($slide);
    }

    public function show($id)
    {
        $slide = $this->slideRepository->find($id) ?? $this->slideRepository->findByCode($id);

        $slide = $this->slideRepository->query([
            'id' => $slide->id
        ]);

        return new SlideResource($slide);
    }

    public function update($id, UpdateSlideRequest $request)
    {
        $slide = $this->slideRepository->find($id) ?? $this->slideRepository->findByCode($id);

        $slide = $this->slideRepository->update(
            $request->validated(),
            $slide->id
        );

        $slide = $this->slideRepository->query([
            'id' => $slide->id
        ]);

        return new SlideResource($slide);
    }

    public function destroy($id)
    {
        $slide = $this->slideRepository->find($id) ?? $this->slideRepository->findByCode($id);

        $this->slideRepository->delete($slide->id);

        return $this->respondSuccess('Xóa slide thành công.');
    }
}
