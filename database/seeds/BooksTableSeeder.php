<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            [ 'state' => 'Abuja'],
            ['state' => 'River'],
            ['state' => 'Edo-Delta'],
            ['state' => 'Ekiti'],
            ['state' => 'Kaduna'],
            ['state' => 'Kano'],
            ['state' => 'Kogi'],
            ['state' => 'Kwara'],
            ['state' => 'Lagos'],
            ['state' => 'Niger'],
            ['state' => 'Ogun'],
            ['state' => 'Ondo'],
            ['state' => 'Osun'],
            ['state' => 'Oyo'],
            ['state' => 'Plateau'],
            ['state' => 'Cross-River']
        ];

        State::insert($states);
    }
}
