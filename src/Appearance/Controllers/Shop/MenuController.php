<?php

namespace Modules\Appearance\Controllers\Shop;

use Modules\Appearance\Repositories\MenuRepository;
use Modules\Appearance\Requests\Shop\IndexMenuRequest;
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

    public function index(IndexMenuRequest $request)
    {
        $menus = $this->menuRepository->query(
            $request->validated()
        );

        return new MenuCollection($menus);
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $menu = $this->menuRepository->find($id) ?? $this->menuRepository->findByCode($id);
        } else {
            $menu = $this->menuRepository->findByCode($id);
        }

        $menu = $this->menuRepository->query([
            'id' => $menu->id
        ]);

        return new MenuResource($menu);
    }
}
