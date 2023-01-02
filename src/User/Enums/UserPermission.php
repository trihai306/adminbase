<?php

namespace Modules\User\Enums;

use BenSampo\Enum\Enum;

class UserPermission extends Enum
{
    const LIST = 'user.list';
    const CREATE = 'user.create';
    const DETAIL = 'user.detail';
    const UPDATE = 'user.update';
    const DELETE = 'user.delete';
    const ROLE_LIST = 'user.role.list';
    const ROLE_CREATE = 'user.role.create';
    const ROLE_DELETE = 'user.role.delete';
}
