<?php

declare(strict_types=1);

namespace Ghostff\FormRequest;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class RequestServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->commands([\Ghostff\FormRequest\Console\RequestMakeCommand::class]);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->resolving(AbstractFormRequest::class, function (Request $request, Application $app) {
            $this->initializeRequest($request, $app['request']);
        });

        $this->app->afterResolving(AbstractFormRequest::class, function (AbstractFormRequest $resolved) {
            $resolved->validateResolved();
        });

    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  \Pearl\RequestValidate\AbstractFormRequest  $form
     * @param  \Illuminate\Http\Request  $current
     * @return void
     */
    protected function initializeRequest(AbstractFormRequest $form, Request $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $form->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );

        $form->setContainer($this->app);
    }
}
