<?php

namespace Modules\User\Enums;

use BenSampo\Enum\Enum;

class RolePermission extends Enum
{
    const LIST = 'role.list';
    const CREATE = 'role.create';
    const UPDATE = 'role.update';
    const DELETE = 'role.delete';
}
