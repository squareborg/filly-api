<?php

use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;

class ProgramCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('program_categories') as $category){
            ProgramCategory::create([
                'name' => $category
            ]);
        }
    }

}
