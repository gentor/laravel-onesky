<?php

namespace Gentor\LaravelOneSky\Commands;


class OneSky extends BaseCommand
{
    protected $signature = 'onesky {--lang=} {--project=}';

    protected $description = 'Get information about OneSky';

    public function handle()
    {
        $client = $this->client();

//        $this->info('Project groups:');
//        $response = $client->projectGroups('list');
//        $response = json_decode($response, true);
//        print_r($response);
//
//        $this->info('Projects list:');
//        foreach ($response['data'] ?? [] as $item) {
//            $this->info('Projects for group #' . $item['id'] . ' ' . $item['name']);
//            $response = $client->projects('list', ['project_group_id' => $item['id']]);
//            $response = json_decode($response, true);
//            print_r($response);
//        }
//
//        $this->info('Supported locales:');
//        $response = $client->locales('list');
//        $response = json_decode($response, true);
//        print_r($response);

        $this->info('Default project:');
        $response = $client->projects('show', ['project_id' => $this->project()]);
        $response = json_decode($response, true);
        print_r($response);

//        $this->info('Default project files:');
//        $response = $client->files('list', ['project_id' => $this->project()]);
//        $response = json_decode($response, true);
//        print_r($response);

//        $this->info('Default project import tasks:');
//        $response = $client->importTasks('list', ['project_id' => $this->project()]);
//        $response = json_decode($response, true);
//        print_r($response);
    }
}
