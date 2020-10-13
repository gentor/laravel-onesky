<?php

namespace Gentor\LaravelOneSky\Commands;

use Gentor\LaravelOneSky\Exceptions\NumberExpected;
use Illuminate\Console\Command;
use File;

class BaseCommand extends Command
{
    protected $result = 0;

    const SUCCESS = 0;
    const UNKNOWN_ERROR = 1;

    public function baseLocale()
    {
        return $this->config()['base_locale'];
    }

    public function locales()
    {
        $localeString = $this->option('lang');
        if ($localeString && $locales = explode(',', $localeString)) {
            return $locales;
        }
        $translationsPath = $this->translationsPath();

        return $this->scanDir($translationsPath, true);
    }

    public function translationsPath()
    {
        $config = $this->config();

        if (isset($config['translations_path'])) {
            return $config['translations_path'];
        }

        return resource_path('lang');
    }

    public function config()
    {
        return $this->laravel->config['onesky'];
    }

    public function project()
    {
        $config = $this->config();
        $project = $this->option('project');

        if (!$project && isset($config['default_project_id'])) {
            $project = $config['default_project_id'];
        }

        if ($project && (string)(int)$project === (string)$project) {
            return $project;
        }

        throw new NumberExpected('--project');
    }

    public function scanDir($dir, $directoriesOnly = false)
    {
        if ($directoriesOnly) {
            return array_map(function ($path) {
                return basename($path);
            }, File::directories($dir));
        }

        return array_map(function ($file) {
            return $file->getFilename();
        }, File::files($dir));
    }

    /**
     * @return \OneSky\Api\Client
     */
    public function client()
    {
        return $this->laravel->make('onesky');
    }
}
