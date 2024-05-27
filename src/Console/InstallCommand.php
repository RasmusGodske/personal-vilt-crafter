<?php

namespace RasmusGodske\ViltCrafter\Console;

use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Process\Process;
use RuntimeException;
use Illuminate\Filesystem\Filesystem;

#[AsCommand(name: 'viltcrafter:install')]
class InstallCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'viltcrafter:install
        {--vscode : Indicate if you want to install the VSCode Settings}
        {--bootstrap-script : Indicate if you want to include bootstrap script}
        {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the viltcrafter components and resources';

     /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $this->info('Installing viltcrafter...');

        $this->installInertiaStack();

        if ($this->option('bootstrap-script')) {
          $this->publishBootstrapScript();
        }

    }


    protected function installInertiaStack() {
      if (! $this->requireComposerPackages([
        'inertiajs/inertia-laravel:^1.2',
        'tightenco/ziggy:^2.1',
        ]))
      {
        return false;
      }

      $this->setupTypescript();



      // ---- Creating Root Template ----
      // Override resources/views/app.blade.php
      $app_blade_path = resource_path('views/app.blade.php');

      $app_blade_exists = file_exists($app_blade_path);

      if ($app_blade_exists === false) {
        copy(__DIR__.'/../../stubs/resources/views/app.blade.php', $app_blade_path);
      } else {
        $this->warn('app.blade.php already exists. Skipping...');
      }

      // ---- Create Inertia middleware ----

      // Check that file exists
      if (! file_exists(app_path('Http/Middleware/HandleInertiaRequests.php'))) {
        $this->runCommands(['php artisan inertia:middleware']);

      } else {
        $this->warn('HandleInertiaRequests.php already exists. Skipping...');
      }

      // Add Inertia middleware to the web middleware group...

      // Replace the bootstrap/app.php with stubs/bootstrap/app.php
      $bootstrap_app_path = base_path('bootstrap/app.php');

      // Check if 'HandleInertiaRequests::class' is already in the file
      $appFile = file_get_contents($bootstrap_app_path);
      if (strpos($appFile, 'HandleInertiaRequests::class') === false) {
        copy(__DIR__.'/../../stubs/bootstrap/app.php', $bootstrap_app_path);
      } else {
        $this->warn('HandleInertiaRequests::class already exists in bootstrap/app.php. Skipping...');
      }

      // ---- Setup Inertia.js Client-side ----

      // Install NPM packages...
      $this->updateNodePackages(function ($packages) {
        return [
            '@inertiajs/vue3' => '^1.0.16',
            '@vitejs/plugin-vue' => '^5.0.4',
        ] + $packages;
      });



      // Update vite.config.js
      $vite_config_path = base_path('vite.config.js');

      // Check that if '@vitejs/plugin-vue' is already in the file
      $viteFile = file_get_contents($vite_config_path);
      if (strpos($viteFile, '@vitejs/plugin-vue') === false) {
        copy(__DIR__.'/../../stubs/vite.config.js', $vite_config_path);
      } else {
        $this->warn('vite.config.js. already seems to be updated Skipping...');
      }

      // Update resources/js/app.js


      // rename the existing app.js to app.ts
      if (file_exists(resource_path('js/app.js'))) {
        rename(resource_path('js/app.js'), resource_path('js/app.ts'));
      }


      $app_ts_path = resource_path('js/app.ts');

      // Check that if '@inertiajs/vue3' is already in the file
      $appJsFile = file_get_contents($app_ts_path);
      if (strpos($appJsFile, '@inertiajs/vue3') === false) {
        copy(__DIR__.'/../../stubs/resources/js/app.ts', $app_ts_path);
      } else {
        $this->warn('app.ts already seems to be updated. Skipping...');
      }

      // Create welcome page
      (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));

      // Copy resouces/js/Pages/Welcome.vue

      $dashboard_vue_path = resource_path('js/Pages/Dashboard.vue');

      // Check if file exists
      if (! file_exists($dashboard_vue_path)) {
        copy(__DIR__.'/../../stubs/resources/js/Pages/Dashboard.vue', $dashboard_vue_path);
      } else {
        $this->warn('Dashboard.vue already exists. Skipping...');
      }

      // Create dashboard controller
      $dashboard_controller_path = app_path('Http/Controllers/DashboardController.php');

      // Check if file exists
      if (! file_exists($dashboard_controller_path)) {
        copy(__DIR__.'/../../stubs/app/Http/Controllers/DashboardController.php', $dashboard_controller_path);
      } else {
        $this->warn('DashboardController.php already exists. Skipping...');
      }

      // Add dashboard route to routes/web.php

      // Check if '/dashboard' is present in the file
      $webFile = file_get_contents(base_path('routes/web.php'));
      if (strpos($webFile, '/dashboard') === false) {
        // Add the following line to the file
        file_put_contents(base_path('routes/web.php'), PHP_EOL . "Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');" . PHP_EOL, FILE_APPEND);
      } else {
        $this->warn('Dashboard route already exists in routes/web.php. Skipping...');
      }


      // ---- Installing Tailwind CSS ----

      // Install NPM packages...
      $this->updateNodePackages(function ($packages) {
        return [
            'tailwindcss' => '^3.4.0',
            'postcss' => '^8.4.0',
            'autoprefixer' => '^10.4.19',
        ] + $packages;
      });


      // Update the tailwind.config.js
      $tailwind_config_path = base_path('tailwind.config.js');

      // check if file exists
      if (! file_exists($tailwind_config_path)) {
        copy(__DIR__.'/../../stubs/tailwind.config.js', $tailwind_config_path);
      } else {
        $this->warn('tailwind.config.js already exists. Skipping...');
      }

      // create `postcss.config.js`
      $postcss_config_path = base_path('postcss.config.js');

      // check if file exists
      if (! file_exists($postcss_config_path)) {
        copy(__DIR__.'/../../stubs/postcss.config.js', $postcss_config_path);
      } else {
        $this->warn('postcss.config.js already exists. Skipping...');
      }

      // Update `resources/css/app.css`

      // add the following tthree lines to the file:
      // @tailwind base;
      // @tailwind components;
      // @tailwind utilities;
      $app_css_path = resource_path('css/app.css');

      // Add the following lines to the file if they are not already present
      $appCssFile = file_get_contents($app_css_path);
      if (strpos($appCssFile, '@tailwind') === false) {
        file_put_contents($app_css_path, PHP_EOL . "@tailwind base;", FILE_APPEND);
        file_put_contents($app_css_path, PHP_EOL . "@tailwind components;", FILE_APPEND);
        file_put_contents($app_css_path, PHP_EOL . "@tailwind utilities;", FILE_APPEND);
      } else {
        $this->warn('app.css already seems to be updated. Skipping...');
      }

      // Update `resources/js/app.js` to import `app.css`
      $appJsFile = file_get_contents($app_ts_path);
      if (strpos($appJsFile, 'import \'../css/app.css\';') === false) {
        // add the following `import ../css/app.css` to the start of the file
        file_put_contents($app_ts_path, "import '../css/app.css';" . PHP_EOL . $appJsFile);
      } else {
        $this->warn('app.js already seems to be updated. Skipping...');
      }

      // Add VSCode settings
      if ($this->option('vscode')) {
        $this->info('Installing VSCode settings...');

        // Create .vscode folder
        (new Filesystem)->ensureDirectoryExists(base_path('.vscode'));

        // Copy .vscode/launch.json
        $launch_json_path = base_path('.vscode/launch.json');
        if (! file_exists($launch_json_path)) {
          copy(__DIR__.'/../../stubs/vscode/launch.json', $launch_json_path);
        } else {
          $this->warn('launch.json already exists. Skipping...');
        }

        // Copy .vscode/settings.json
        $settings_json_path = base_path('.vscode/settings.json');
        if (! file_exists($settings_json_path)) {
          copy(__DIR__.'/../../stubs/vscode/settings.json', $settings_json_path);
        } else {
          $this->warn('settings.json already exists. Skipping...');
        }

        // Copy .vscode/settings.json
        $tasks_json_path = base_path('.vscode/tasks.json');
        if (! file_exists($tasks_json_path)) {
          copy(__DIR__.'/../../stubs/vscode/tasks.json', $tasks_json_path);
        } else {
          $this->warn('tasks.json already exists. Skipping...');
        }

        // Update .env and .env.example
        $env_path = base_path('.env');
        $env_example_path = base_path('.env.example');

        // Add the following lines
        // SAIL_XDEBUG_MODE="develop,debug,trace,coverage"
        $sail_debug_config = 'SAIL_XDEBUG_CONFIG="client_host=host.docker.internal client_port=9003 start_with_request=default idekey=VSCODE"';
        $sail_xdebug_mode = 'SAIL_XDEBUG_MODE="develop,debug,trace,coverage"';

        // Check if the lines are already present in the file
        $envFile = file_get_contents($env_path);

        // --------- Update .env ---------
        if (strpos($envFile, $sail_debug_config) === false) {
          file_put_contents($env_path, PHP_EOL . $sail_debug_config, FILE_APPEND);
        } else {
          $this->warn('SAIL_XDEBUG_CONFIG already exists in .env. Skipping...');
        }

        if (strpos($envFile, $sail_xdebug_mode) === false) {
          file_put_contents($env_path, PHP_EOL . $sail_xdebug_mode, FILE_APPEND);
        } else {
          $this->warn('SAIL_XDEBUG_MODE already exists in .env. Skipping...');
        }

        // --------- Update .env.example ---------
        $envExampleFile = file_get_contents($env_example_path);

        if (strpos($envExampleFile, $sail_debug_config) === false) {
          file_put_contents($env_example_path, PHP_EOL . $sail_debug_config, FILE_APPEND);
        } else {
          $this->warn('SAIL_XDEBUG_CONFIG already exists in .env.example. Skipping...');
        }

        if (strpos($envExampleFile, $sail_xdebug_mode) === false) {
          file_put_contents($env_example_path, PHP_EOL . $sail_xdebug_mode, FILE_APPEND);
        } else {
          $this->warn('SAIL_XDEBUG_MODE already exists in .env.example. Skipping...');
        }

      }

      $this->runCommands(['npm install', 'npm run build']);
    }

    protected function setupTypescript() {
      // Install NPM packages...
      $this->updateNodePackages(function ($packages) {
        return [
            '@types/node' => '^20.12.11',
            'typescript' => '^5.4.5',
        ] + $packages;
      });



      // Update tsconfig.json
      $tsconfig_path = base_path('tsconfig.json');

      if (! file_exists($tsconfig_path)) {
        copy(__DIR__.'/../../stubs/tsconfig.json', $tsconfig_path);
      } else {
        $this->warn('tsconfig.json already exists. Skipping...');
      }

      (new Filesystem)->ensureDirectoryExists(resource_path('js/types'));

      // Copy resources/js/types/inertia.d.ts
      $inertia_d_ts_path = resource_path('js/types/inertia.d.ts');

      if (! file_exists($inertia_d_ts_path)) {
        copy(__DIR__.'/../../stubs/resources/js/types/vue-ziggy.d.ts', $inertia_d_ts_path);
      } else {
        $this->warn('inertia.d.ts already exists. Skipping...');
      }

      // Copy resources/js/types/ziggy.d.ts
      $ziggy_d_ts_path = resource_path('js/types/vue-ziggy.d.ts');

      if (! file_exists($ziggy_d_ts_path)) {
        copy(__DIR__.'/../../stubs/resources/js/types/vue-ziggy.d.ts', $ziggy_d_ts_path);
      } else {
        $this->warn('vue-ziggy.d.ts already exists. Skipping...');
      }
    }

    protected function publishBootstrapScript() {
      // Copy stubs/scripts/bootstrap.sh to the scripts/bootstrap.sh

      // create scripts folder
      (new Filesystem)->ensureDirectoryExists(base_path('scripts'));

      $bootstrap_sh_path = base_path('scripts/bootstrap.sh');

      // Check if file exists
      if (! file_exists($bootstrap_sh_path)) {
        copy(__DIR__.'/../../stubs/scripts/bootstrap.sh', $bootstrap_sh_path);
      } else {
        $this->warn('bootstrap.sh already exists. Skipping...');
      }

    }



    // --------------------------- Copied from Laravel Jetstream ---------------------------
    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return bool
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        return ! (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

}