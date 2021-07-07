<?php


namespace YiluTech\ApiDocGenerator\Commands;


use Illuminate\Console\Command;
use YiluTech\ApiDocGenerator\ApiDocGenerator;

class ApiDocGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'api-doc:generate {path?} {--yaml} {--json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate api document.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $type = $this->getFileType();

        if (!$type) return;

        $path = $this->getPath($type);

        $parser = new ApiDocGenerator();

        if ($type === 'yaml') {
            yaml_emit_file($path, $parser->toArray(), YAML_UTF8_ENCODING);
        }

        if ($type === 'json') {
            file_put_contents($path, $parser->toJson());
        }

        $this->info(sprintf('generate success, in path: %s', $path));
    }

    protected function getFileType()
    {
        if ($this->option('json')) {
            return 'json';
        }
        if ($this->checkYamlExt()) {
            return 'yaml';
        } else if ($this->option('yaml')) {
            $this->error('miss yaml extension!');
            return false;
        }
        return 'json';
    }

    protected function getPath($suffix)
    {
        return public_path($this->argument('path') ?? "swagger.$suffix");
    }

    protected function checkYamlExt()
    {
        return function_exists('yaml_emit_file');
    }
}