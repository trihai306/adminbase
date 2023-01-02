<?php

namespace Modules\Appearance\Controllers\Shop;

use Modules\Appearance\Repositories\SlugRepository;
use Modules\Appearance\Transformers\SlugCollection;
use Modules\Appearance\Transformers\SlugResource;
use Modules\Core\Controllers\Controller;

class SlugController extends Controller
{
    private $slugRepository;

    public function __construct(SlugRepository $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    public function index()
    {
        $slugs = $this->slugRepository->query([]);

        return new SlugCollection($slugs);
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $slug = $this->slugRepository->find($id) ??
                $this->slugRepository->findBySlug($id);
        } else {
            $slug = $this->slugRepository->findBySlug($id);
        }

        $slug = $this->slugRepository->query([
            'id' => $slug->id
        ]);

        return new SlugResource($slug);
    }

    public function showSlug($prefix, $id)
    {
        $slug = $this->slugRepository->findBySlugWithPrefix($id, $prefix);

        $slug = $this->slugRepository->query([
            'id' => $slug->id
        ]);

        return new SlugResource($slug);
    }
}
