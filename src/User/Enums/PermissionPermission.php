<?php

namespace Modules\User\Enums;

use BenSampo\Enum\Enum;

class PermissionPermission extends Enum
{
    const LIST = 'permission.list';
    const CREATE = 'permission.create';
    const UPDATE = 'permission.update';
    const DELETE = 'permission.delete';
}
