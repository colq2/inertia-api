## How to reuse Inertia Controller for your API

I worked on multiple projects with Inertia.js and Laravel. And nearly everytime I stumbled upon the same problem: When I needed an api, I always thought if I can reuse my Inertia Controllers for my API.
There are several people on Laracasts questioning the same thing.

This repository is a simple example and idea how to achieve this. Discussions are very welcome.


## Installation
Here just some quick steps to install the repository.

```bash
git clone 
cd inertia-api
composer install
npm install
npm run dev
php artisan migrate --seed
php artisan serve
# or use valet or herd
```

You can see some posts on /posts route. You can find the implementation in `PostsController.php` and `PostsResource.php`.

## The Idea

The idea is to create a middleware that sets the 'X-Inertia' header. This forces Inertia to return a JSON response. The middleware take the response, changes the data structure a bit and returns it.

The middleware is called `InertiaToApiResponse` and looks like this:

```php
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
```

There is an api route with this middleware applied. You can find it in `api.php`:

```php
Route::middleware(InertiaToApiResponse::class)->group(function () {
   Route::apiResource('posts', \App\Http\Controllers\PostController::class);
});
```

Which transforms the response from

```json

{
  "component": "Posts/Index",
  "props": {
    "posts": {
      "data": []
    }
  },
  "url": "/posts",
  "version": "abcde"
}
```

to
```json
{
  "data": {
    "posts": {
      "data": []
    }
  },
  "url": "/posts"
}
```

And we can call the api now
```bash
curl -X GET --location "http://inertia-api.test/api/posts" --http2 \
    -H "Accept: application/json" \
    -H "Content-Type: application/json"
```