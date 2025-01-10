<?php

namespace App\Query;

class ProductQuery
{
    public array $queryOperators = [
        'eq' => 'LIKE',
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
    ];

    public function filter(array $querys): array
    {
        $filters = [];
        foreach ($querys as $query => $param) {
            foreach ($param as $operator => $value) {
                $filters[] = [
                    "{$query}",
                    "{$this->queryOperators["{$operator}"]}",
                    $operator === 'eq' ? "%{$value}%" : $value,
                ];
            }
        }

        return $filters;
    }
}
