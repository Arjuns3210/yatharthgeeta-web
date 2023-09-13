<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VideoCategory;
use App\Models\VideoCategoryTranslation;

class VideoCategoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videoCategoryData = [
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
        foreach ($videoCategoryData as $data){
            VideoCategory::create($data);
        }
    }
}
