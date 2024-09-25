<?php

namespace App\Filter;

class Search
{
    public ?string $searchname = null;
    public ?array $searchCategories = [];

    public function __toString(): string
    {
        $searchname = $this->searchname ?? 'Nom non défini';
        $categories = !empty($this->searchCategories) ? implode(', ', $this->searchCategories) : 'Pas de catégories';

        return $searchname . ' (' . $categories . ')';
    }
}
