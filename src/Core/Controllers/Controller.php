<?php

namespace Modules\Core\Controllers;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondSuccess($message, $status = 200)
    {
        return response()->json([
            'message' => $message
        ], $status);
    }

    protected function respondError($code, $message, $status = 500)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ], $status);
    }
}
