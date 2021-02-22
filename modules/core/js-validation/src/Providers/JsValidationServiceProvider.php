<?php
namespace EG\JsValidation\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use EG\Base\Traits\LoadAndPublishTrait;
use EG\JsValidation\JsValidatorFactory;
use EG\JsValidation\RemoteValidationMiddleware;
use EG\JsValidation\Javascript\ValidatorHandler;

class JsValidationServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function boot()
    {
        $this->setNamespace('core/js-validation')
          ->loadAndPublishConfigurations(['js-validation'])
          ->loadAndPublishViews()
          ->publishAssets();

        $this->bootstrapValidator();

        if ($this->app['config']->get('core.js-validation.js-validation.disable_remote_validation') === false) {
          $this->app[Kernel::class]->pushMiddleware(RemoteValidationMiddleware::class);
        }

    }


    protected function bootstrapValidator()
    {
       $callback = function () {
            return true;
        };
        $this->app['validator']->extend(ValidatorHandler::JS_VALIDATION_DISABLE, $callback);
    }


    public function register()
    {
      $this->app->singleton('js-validator', function ($app) {
        $config = $app['config']->get('core.js-validation.js-validation');

        return new JsValidatorFactory($app, $config);
      });
    }


}
