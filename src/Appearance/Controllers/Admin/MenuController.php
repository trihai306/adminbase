<?php

namespace Modules\Appearance\Controllers\Admin;

use Modules\Appearance\Repositories\MenuRepository;
use Modules\Appearance\Requests\Admin\IndexSlideRequest;
use Modules\Appearance\Requests\Admin\StoreMenuRequest;
use Modules\Appearance\Requests\Admin\UpdateMenuRequest;
use Modules\Appearance\Transformers\MenuCollection;
use Modules\Appearance\Transformers\MenuResource;
use Modules\Core\Controllers\Controller;

class MenuController extends Controller
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function index(IndexSlideRequest $request)
    {
        $menus = $this->menuRepository->query(
            $request->validated()
        );

        return new MenuCollection($menus);
    }

    public function store(StoreMenuRequest $request)
    {
        $menu = $this->menuRepository->create(
            $request->validated()
        );

        $menu = $this->menuRepository->query([
            'id' => $menu->id
        ]);

        return new MenuResource($menu);
    }

    public function show($id)
    {
        $menu = $this->menuRepository->find($id) ?? $this->menuRepository->findByCode($id);

        $menu = $this->menuRepository->query([
            'id' => $menu->id
        ]);

        return new MenuResource($menu);
    }

    public function update($id, UpdateMenuRequest $request)
    {
        $menu = $this->menuRepository->find($id) ?? $this->menuRepository->findByCode($id);

        $menu = $this->menuRepository->update(
            $request->validated(),
            $menu->id
        );

        $menu = $this->menuRepository->query([
            'id' => $menu->id
        ]);

        return new MenuResource($menu);
    }

    public function destroy($id)
    {
        $menu = $this->menuRepository->find($id) ?? $this->menuRepository->findByCode($id);

        $this->menuRepository->delete($menu->id);

        return $this->respondSuccess('Xóa menu thành công.');
    }
}
