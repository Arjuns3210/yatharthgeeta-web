<?php

namespace Database\Seeders;

use App\Models\AudioCategory;
use Illuminate\Database\Seeder;

class AddAudioCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $audioCategoryData = [
            [
                'sequence' => 1,
                'status'   => 1,
                'en'       => [
                    'name' => 'Bhagvad Geeta',
                ],
                'hi'       => [
                    'name' => 'भागवद गीता',
                ],
            ],
            [
                'sequence'     => 2,
                'status' => 1,
                'en'       => [
                    'name' => 'Ashram',
                ],
                'hi'       => [
                    'name' => 'आश्रम',
                ],
            ],
            [
                'sequence'     => 99,
                'status' => 1,
                'en'       => [
                    'name' => 'Others',
                ],
                'hi'       => [
                    'name' => 'अन्य',
                ],
            ],
        ];
        foreach ($audioCategoryData as $data){
            AudioCategory::create($data);
        }
    }
}
