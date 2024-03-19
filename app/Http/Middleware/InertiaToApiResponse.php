<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class InertiaToApiResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        // forces inertia to create json response
        $request->headers->set('X-Inertia', true);

        // get response
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);

            // modify data and remove component
            Arr::forget($data, 'component');

            // set move props to data
            $data['data'] = $data['props'];
            Arr::forget($data, 'props');

            // forget version
            Arr::forget($data, 'version');

            $response->setData($data);

            // remote X-Inertia header to not trigger version change response of inertia middleware
            $response->headers->remove('X-Inertia');
        }

        return $response;
    }
}
