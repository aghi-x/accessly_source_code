<?php

namespace App\Modules\Search\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Inertia\Response as InertiaResponse;

interface SearchControllerInterface
{
    /**
     * Perform a global search and return either JSON or Inertia response.
     *
     * @param Request $request
     * @return JsonResponse|InertiaResponse
     */
    public function search(Request $request);
}
