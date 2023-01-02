<?php

namespace Modules\User\Services;

use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepository;

class CustomerService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $attributes): User
    {
        return $this->userRepository->create($attributes);
    }

    public function update(array $attributes, $id): User
    {
        return $this->userRepository->update($attributes, $id);
    }
}
