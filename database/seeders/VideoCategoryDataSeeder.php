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
        $names = ['Bhagvad Geeta', 'Ashram','Others'];
        for($i=0; $i<=2; $i++) {
            $video_category = [
                'status' => '1',
                'sequence' => ($names[$i] === 'Others') ? 99 : ($i+1),
            ];
            $data = VideoCategory::firstOrCreate($video_category);

            foreach (config('translatable.locales') as $locale) {
                $video_category_translation = [
                    'video_category_id' => $data->id,
                    'locale' => $locale,
                    'name' => $names[$i],
                ];
                $translation_data = VideoCategoryTranslation::firstOrCreate($video_category_translation);
            }
        }
    }
}
