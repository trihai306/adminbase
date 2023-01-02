<?php

namespace Modules\Cart\Exceptions;

class OutOfStockException extends \Exception
{
    public function __construct($variant, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Sản phẩm $variant->name đã hết hàng.", $code, $previous);
    }
}
