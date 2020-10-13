<?php

namespace Gentor\LaravelOneSky\Commands;

use Gentor\LaravelOneSky\Exceptions\UnexpectedErrorWhileUploading;

class Push extends BaseCommand
{
    protected $signature = 'onesky:push {--lang=} {--project=}';

    protected $description = 'Push the language files to OneSky';

    public function handle()
    {
        $locales = $this->option('lang') ? $this->locales() : [$this->baseLocale()];

        foreach ($locales as $locale) {
            $this->line('Uploading translations for locale: ' . $locale);
            $translationsPath = $this->translationsPath() . DIRECTORY_SEPARATOR . $locale;

            $files = $this->scanDir($translationsPath);

            $files = array_map(function ($fileName) use (&$locale, &$translationsPath) {
                return $translationsPath . DIRECTORY_SEPARATOR . $fileName;
            }, $files);

            $this->uploadFiles(
                $this->client(),
                $this->project(),
                $locale,
                $files
            );

            $this->line('Files were uploaded successfully!');
        }
    }

    /**
     * @param \OneSky\Api\Client $client
     * @param $project
     * @param $locale
     * @param array $files
     */
    public function uploadFiles($client, $project, $locale, array $files)
    {
        $data = $this->prepareUploadData($project, $locale, $files);

        foreach ($data as $d) {
            $this->info("Uploading file {$d['file']}");
            $client->files('upload', $d);
        }
    }

    public function uploadFile($client, $data)
    {
        $jsonResponse = $client->files('upload', $data);
        $jsonData = json_decode($jsonResponse, true);
        $responseStatus = $jsonData['meta']['status'];

        if ($responseStatus !== 201) {
            throw new UnexpectedErrorWhileUploading(
                'Upload response status: ' . $responseStatus
            );
        }
    }

    public function prepareUploadData($project, $locale, array $files)
    {
        $data = [];
        foreach ($files as $file) {
            $data[] = [
                'project_id' => $project,
                'file' => $file,
                'file_format' => 'PHP_SHORT_ARRAY',
                'locale' => array_key_exists($locale, $this->config()['locale_mapping']) ?
                    $this->config()['locale_mapping'][$locale] : $locale,
            ];
        }

        return $data;
    }
}
