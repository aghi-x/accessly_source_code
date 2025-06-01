<?php

namespace App\Modules\Search\Controllers;

use App\Modules\Search\Interfaces\SearchControllerInterface;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Modules\Search\Services\SearchService;

class SearchController implements SearchControllerInterface
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function search(Request $request)
    {
        if (Gate::denies('search')) {
            return Inertia::render('Unauthorized');
        }

        $query = $request->input('q', '');

        $results = $this->searchService->performSearch($query);

        if ($request->expectsJson()) {
            return response()->json($results);
        }

        return Inertia::render('Search/Pages/GlobalSearch', array_merge(['query' => $query], $results));
    }
}
