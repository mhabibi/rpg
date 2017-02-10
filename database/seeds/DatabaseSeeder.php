<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private static $story = [
        1  => [
            'title'       => 'A man around the world!',
            'description' => 'It is a story about a man with a backpack who traveled around the world.',
            'cost'        => 0,
            'options'     => [2],
        ],
        2  => [
            'title'       => 'Pack your backpack and get ready!',
            'description' => 'Get your travel stuff together and let\'s go. Don\'t forget to take some money!',
            'cost'        => 0,
            'options'     => [3],
        ],
        3  => [
            'title'       => 'Start!',
            'description' => 'To start you should choose which part of the world you would like to go.
Choose one option: ',
            'cost'        => 300,
            'options'     => [4, 5, 6],
        ],
        4  => [
            'title'       => 'South America (ticket: 200 GOLD)',
            'description' => '',
            'cost'        => -200,
            'options'     => [7],

        ],
        5  => [
            'title'       => 'Southeast Asia (ticket: 150 GOLD)',
            'description' => '',
            'cost'        => -150,
            'options'     => [11, 12],
        ],
        6  => [
            'title'       => 'East Europe (ticket: 100 GOLD)',
            'description' => 'You have settled in Lithuania! ',
            'cost'        => -100,
            'options'     => [16],
        ],
        7  => [
            'title'       => 'Living in Mexico',
            'description' => 'You have settled in Mexico! You have rented a room in Nuevo Laredo. Life goes on peacefully. One morning, when yu are walking down a street, a man asks you that what are you doing in this city. You don\'t want to answer, so you walk away.
The man shouts to get you back, you have to decide: ',
            'cost'        => -100,
            'options'     => [8, 9],
        ],
        8  => [
            'title'       => 'Continue walking',
            'description' => 'While you\'re walking you get shot in your back!',
            'cost'        => 0,
            'options'     => [10]
        ],
        9  => [
            'title'       => 'Turn back and wait to listen to him',
            'description' => 'When you turn back, you face the man standing with a gun pointed at you.
A moment after you feel hurt in your chest and warm whole your body. You got shot! Blood is all over your cloths...',
            'cost'        => 0,
            'options'     => [10]
        ],
        10 => [
            'title'       => 'Death! Your life was too short!',
            'description' => 'R.I.P R.I.P R.I.P R.I.P R.I.P R.I.P',
            'cost'        => 0,
        ],
        11 => [
            'title'       => 'Vietnam',
            'description' => 'It\'s been 1 year that you have been living in DaNang, in the middle of Vietnam.
One day in the beach you see a very beautiful girl which is really different with other Vietnamese girls. You ask her to be your girlfriend. Do you think she accepts?',
            'cost'        => -50,
            'options'     => [13, 14],
        ],
        12 => [
            'title'       => 'Thailand',
            'description' => 'You arrive in Bangkok and you don\'t know where to go. You walk into a bar to drink. After one hour a very beautiful girl starts talking with you.
When you are totally drunk she offers you to take you to her home for a rest. You accept and half an hour later you and her are in her sleeping room. But there is a problem, she is not a girl as you expected! And now it\'s too late to escape.
After two years from that night you find out that you are HIV positive. You know this can kill you after a few years, so...',
            'cost'        => 0,
            'options'     => [10],
        ],
        13 => [
            'title'       => 'No',
            'description' => 'Oops! Yeah, maybe she has somebody else. That\'s sad. You can recover, if you go back to where you came from.
You decide to go home and live there forever and never leave your hometown again.',
            'cost'        => 0,
        ],
        14 => [
            'title'       => 'Yes',
            'description' => 'Yeay! You are right, she accepts your request, and you start a happy life. After 2 years you decide you get married with her. You need a job, but as somebody who has never had a job, it is not easy. So you decide to rob motorbikes on the street and sell them. you make a lot of money with it.',
            'cost'        => 7500,
            'options'     => [15],
        ],
        15 => [
            'title'       => 'Police',
            'description' => 'With the money you get rich enough and finally get married with her. But one day police decide you stop you and you are scared if they arrest you. So you continue your way.
While you are driving, another bike crashes to yours and you lose the control and get seriously hurt. Your wife spends all the money to keep you alive but it is not possible. After one month in hospital you die.',
            'cost'        => -7500,
            'options'     => [10],
        ],
        16 => [
            'title'       => 'East Europe (ticket: 100 GOLD)',
            'description' => 'This story is not completed...',
            'cost'        => 0,
            'options'     => [],
        ],
    ];

    public function run()
    {
        \Illuminate\Support\Facades\DB::table('states')->truncate();
        \Illuminate\Support\Facades\DB::table('options')->truncate();

        foreach (static::$story as $stateId => $state) {
            $options = null;
            if (isset($state['options'])) {
                $options = $state['options'];
                unset($state['options']);
            }
            factory(\App\Models\StateModel::class)->create($state);
            if ($options && count($options)) {
                foreach ($options as $child) {
                    \Illuminate\Support\Facades\DB::table('options')->insert(['parent' => $stateId, 'child' => $child]);
                }
            }
        }
    }
}
