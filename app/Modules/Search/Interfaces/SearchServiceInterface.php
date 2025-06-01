<?php

namespace App\Modules\Search\Interfaces;

interface SearchServiceInterface
{
    /**
     * Perform a search across users, roles, and permissions.
     *
     * @param string $query
     * @return array{
     *     users: \Illuminate\Support\Collection,
     *     roles: \Illuminate\Support\Collection,
     *     permissions: \Illuminate\Support\Collection
     * }
     */
    public function performSearch(string $query): array;
}
