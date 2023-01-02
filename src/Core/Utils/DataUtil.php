<?php

namespace Modules\Core\Utils;

class DataUtil
{
    public static function analyseUpdated(array $data): array
    {
        $newValues = [];
        $existedValues = [];
        $existedValueIds = [];

        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newValues[] = $value;
            } else {
                $existedValues[] = $value;
                $existedValueIds[] = $value['id'];
            }
        }

        return [$newValues, $existedValues, $existedValueIds];
    }
}
