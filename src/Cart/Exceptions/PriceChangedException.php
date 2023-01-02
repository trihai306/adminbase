<?php

namespace Modules\Cart\Exceptions;

class PriceChangedException extends \Exception
{
    public function __construct($variant, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Giá bán sản phẩm $variant->sale_price đã thay đổi.", $code, $previous);
    }
}
