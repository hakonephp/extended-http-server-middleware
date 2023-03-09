# Extended PSR-15 HTTP middleware interfaces 🏃‍♀️

This package provides a useful interface to [PSR-15] compatible purpose-specific middleware.

This interface was designed for Hakone, but is compatible with all other PSR-15 middleware dispatchers. All middleware that implements this interface satisfies the [Liskov substitution principle].

## `RequestInterceptionMiddleware`

This specialized middleware only touches the request and asserts that it will return the response returned by the request handler as-is.

One use case is simply appending values to the request via `ServerRequstInterface::withAttribute()`.

```php
class AppendFooMiddleware implements RequestInterceptionMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request->withHeader(Foo::class, new Foo());

        return $handler->handle($request);
    }
}
```

The next use case is to redirect on certain conditions. It is valid to create and return a new response object in middleware.

```php
class RedirectHostMiddleware implements RequestInterceptionMiddleware
{
    public function __construct(
        private ResponseFactoryInterface $response_factory
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $host = $request->getHeader('Host')[0] ?? null;

        if (strlower($host) === 'old.example.com') {
            return $response_factory->createResponse(301)
                ->withHeader('Location', 'https://new.example.com');
        }

        return $handler->handle($request);
    }
}
```

If your application handles exceptions, you could abort the process like this:

```php
class RejectBadReferrerMiddleware implements RequestInterceptionMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $referrer = $request->getHeader('Referer')[0] ?? null;

        if (strlower($referer) === 'evil.example.com') {
            throw new BadRequestException();
        }

        return $handler->handle($request);
    }
}
```

## Copyright

```
Copyright 2023 USAMI Kenta <tadsan@zonu.me>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```

[Liskov substitution principle]: https://en.wikipedia.org/wiki/Liskov_substitution_principle
[PSR-15]: https://www.php-fig.org/psr/psr-15/
