<?php

namespace Oxygencms\Commands\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class OxyMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'oxy:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crud generator';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }

        $this->createFactory();
        $this->createMigration();
        $this->createPolicy();
        $this->createController();
        $this->createAdminController();
        $this->createRequest();
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => 'Models\\' . $this->argument('name'),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:controller', [
            'name' => "{$controller}Controller",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create an admin controller for the model.
     *
     * @return void
     */
    protected function createAdminController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('oxy:make:admin-controller', [
            'name' => "{$controller}Controller",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a policy for the model.
     *
     * @return void
     */
    protected function createPolicy()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = 'Models\\' . $this->qualifyClass($this->getNameInput());

        $this->call('oxy:make:policy', [
            'name' => "{$controller}Policy",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a policy for the model.
     *
     * @return void
     */
    protected function createRequest()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $this->call('oxy:make:request', [
            'name' => "{$controller}Request",
            '--model' => $controller,
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return __DIR__ . '/stubs/pivot.model.stub';
        }

        return __DIR__ . '/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, factory, and resource controller for the model'],

            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],

            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],

            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists.'],

            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model.'],

            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model.'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller.'],
        ];
    }
}
