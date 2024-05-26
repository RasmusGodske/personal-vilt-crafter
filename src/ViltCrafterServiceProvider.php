<?php


namespace RasmusGodske\ViltCrafter;

use Illuminate\Support\ServiceProvider;

class ViltCrafterServiceProvider extends ServiceProvider
{
    public function boot()
    {

      if ($this->app->runningInConsole()) {
        $this->commands([
          Console\InstallCommand::class,
        ]);
      }
    }
}