<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private static $story = [
        1 => [
            'title'       => 'A man around the world!',
            'description' => 'It is a story about a man with a backpack who traveled around the world.',
            'cost'        => 0,
            'options'     => [2],
        ],
        2 => [
            'title'       => 'Pack your backpack and get ready!',
            'description' => 'Get your travel stuff together and let\' go',
            'cost'        => 0,
            'options'     => [3],
        ],
        3 => [
            'title'       => 'Start!',
            'description' => 'To start you should choose which part of the world you would like to go.
            Choose one option: ',
            'cost'        => 300,
            'options'     => [4, 5, 6, 7],
        ],
        4 => [
            'title'       => 'Africa (ticket: 250 GOLD)',
            'description' => '',
            'cost'        => -250,
            'options'     => [],

        ],
        5 => [
            'title'       => 'South America (ticket: 200 GOLD)',
            'description' => '',
            'cost'        => -200,
            'options'     => [],

        ],
        6 => [
            'title'       => 'Southeast Asia (ticket: 150 GOLD)',
            'description' => '',
            'cost'        => -150,
            'options'     => [],

        ],
        7 => [
            'title'       => 'East Europe (ticket: 100 GOLD)',
            'description' => '',
            'cost'        => -100,
            'options'     => [],

        ],
    ];

    public function run()
    {
        \Illuminate\Support\Facades\DB::table('states')->truncate();
        \Illuminate\Support\Facades\DB::table('options')->truncate();

        foreach (static::$story as $stateId => $state) {
            $options = $state['options'];
            unset($state['options']);
            factory(\App\Models\StateModel::class)->create($state);
            if ($options && count($options)) {
                foreach ($options as $child) {
                    \Illuminate\Support\Facades\DB::table('options')->insert(['parent' => $stateId, 'child' => $child]);
                }
            }
        }
    }
}
