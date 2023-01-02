<?php

namespace Modules\Catalog\Controllers\Shop;


use Modules\Catalog\Repositories\UserVoucherRepository;
use Modules\Catalog\Requests\Admin\IndexVoucherRequest;
use Modules\Catalog\Transformers\UserVoucherCollection;
use Modules\Catalog\Transformers\UserVoucherResource;
use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\AuthenticationService;

class UserVoucherController extends Controller
{

    private $authenticationService;
    private $userVoucherRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        UserVoucherRepository $userVoucherRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->userVoucherRepository = $userVoucherRepository;
    }

    public function index(IndexVoucherRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $vouchers = $this->userVoucherRepository->query(
            $data
        );

        return new UserVoucherCollection($vouchers);
    }
    public function show($id){
        $voucher = $this->userVoucherRepository->query(compact('id'));
        return new UserVoucherResource($voucher);
    }
}
