<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\LanguageTranslation;
use App\Models\Language;

class LanguageDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code = ["en", "hi"];
        $name['en'] = [
            "en" => "English",
            "hi" => "अंग्रेज़ी"
        ];

        $name['hi'] = [
            "en" => "Hindi",
            "hi" => "हिंदी"
        ];

        for($i=0; $i < 2; $i++) {
            $language = [
                'language_code' => $code[$i],
                'status' => '1',
                'visible_on_app' => '1',
                'sequence' => ($i+1),
            ];

            $data = Language::firstOrCreate($language);
            
            foreach (config('translatable.locales') as $locale) {
                $language_translation = [
                    'language_id' => $data->id,
                    'locale' => $locale,
                    'name' => $name[$data->language_code][$locale]
                ];
                $translation_data = LanguageTranslation::firstOrCreate($language_translation);

            }

        }
    }
}
