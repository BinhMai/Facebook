<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
			[
				[
					'name' => 'ninh',
					'password' => bcrypt('123456'),
					'created_at' => new DateTime(),
				],
				[
					'name' => 'binh',
					'password' => bcrypt('123456'),
					'created_at' => new DateTime(),
				],
				[
					'name' => 'loan',
					'password' => bcrypt('123456'),
					'created_at' => new DateTime(),
				]
			]
		);
    }
}
