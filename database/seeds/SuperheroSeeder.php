<?php

use App\Superhero;
use Illuminate\Database\Seeder;

class SuperheroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superheros = [
			[ 'name' => 'Proffesor X', 'gender' => 'Laki-laki' ],
			[ 'name' => 'Wolverine', 'gender' => 'Laki-laki' ],
			[ 'name' => 'Raven', 'gender' => 'Perempuan' ],
			[ 'name' => 'Beast', 'gender' => 'Laki-laki' ],
			[ 'name' => 'Storm', 'gender' => 'Perempuan' ],
		];

		foreach ($superheros as $superhero) {
			Superhero::create($superhero);
		}
    }
}
