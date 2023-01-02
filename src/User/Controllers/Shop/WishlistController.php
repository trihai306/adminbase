<?php

namespace Modules\User\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\WishlistRepository;
use Modules\User\Requests\Shop\StoreWishlistRequest;
use Modules\User\Services\AuthenticationService;
use Modules\User\Transformers\WishlistCollection;
use Modules\User\Transformers\WishlistResource;

class WishlistController extends Controller
{
    private $authenticationService;
    private $wishlistRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        WishlistRepository $wishlistRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->wishlistRepository = $wishlistRepository;
    }

    public function index()
    {
        $user = $this->authenticationService->currentUser();

        $wishlists = $this->wishlistRepository->query([
            'user_id' => $user->id
        ]);

        return new WishlistCollection($wishlists);
    }

    public function store(StoreWishlistRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $wishlist = $this->wishlistRepository->create(
            array_merge($request->validated(), [
                'user_id' => $user->id
            ])
        );

        $wishlist = $this->wishlistRepository->query([
            'id' => $wishlist->id
        ]);

        return new WishlistResource($wishlist);
    }

    public function destroy($id)
    {
        $user = $this->authenticationService->currentUser();

        $wishlist = $this->wishlistRepository->query([
            'id' => $id,
            'user_id' => $user->id
        ]);

        $this->wishlistRepository->delete($wishlist->id);

        return $this->respondSuccess('Xóa yêu thích thành công.');
    }
}
