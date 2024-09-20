<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Lomkit\Rest\Documentation\Schemas\OpenAPI;
use Lomkit\Rest\Documentation\Schemas\Operation;
use Lomkit\Rest\Documentation\Schemas\Path;
use Lomkit\Rest\Facades\Rest;

class RestDocumentationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Rest::withDocumentationCallback(function (OpenAPI $openAPI) {
            $openAPI->withPaths(
                [
                    'myPath' => (new Path)
                        ->withDescription('my custom path')
                        ->withGet(
                            (new Operation)
                                ->withTags(['Callable'])
                                ->withSummary('You should call this !')
                        )
                ]
            );
            return $openAPI;
        });
    }
}
