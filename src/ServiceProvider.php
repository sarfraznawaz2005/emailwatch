<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 11/8/2018
 * Time: 11:20 PM
 */

namespace Sarfraznawaz2005\EmailWatch;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Config/config.php' => config_path('emailwatch.php'),
            ]);
        }
    }

    /**
     * @return void
     */
    public function register()
    {
        if (config('emailwatch.enabled')) {
            $this->app->singleton('EmailWatch', function () {
                return $this->app->make(EmailWatch::class);
            });

            Event::listen(MessageSent::class, function (MessageSent $message) {
                $emailWatch = app('EmailWatch');
                $emailWatch->open($message);
            });
        }
    }
}
