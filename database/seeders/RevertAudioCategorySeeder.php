<?php

namespace Database\Seeders;

use App\Models\AudioCategory;
use App\Models\AudioCategoryTranslation;
use Illuminate\Database\Seeder;

class RevertAudioCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $audioCategoryTranslate = [
            'Bhagvad Geeta',
            'भागवद गीता',
            'Ashram',
            'आश्रम',
            'Others',
            'अन्य',
        ];
        $translateIds = AudioCategoryTranslation::whereIn('name', $audioCategoryTranslate)->pluck('id');
        foreach ($translateIds as $id) {
            AudioCategoryTranslation::where('id', $id)->delete($id);
        }

        $audioCategoryIds = [
            1, 2, 3,
        ];
        foreach ($audioCategoryIds as $id) {
            AudioCategory::where('id', $id)->delete();
        }
    }
}
