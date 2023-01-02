<?php

namespace Modules\User\Requests\Traits;

trait HasPaginationRule
{
    protected function withPaginationRule(array $rules): array
    {
        return array_merge($rules, [
            'per_page' => [
                'nullable',
                'integer',
                'min:1'
            ],
            'page' => [
                'nullable',
                'integer',
                'min:1'
            ]
        ]);
    }
}
