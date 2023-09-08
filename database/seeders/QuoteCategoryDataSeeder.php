<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteCategory;
use App\Models\QuoteCategoryTranslation;

class QuoteCategoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Geeta Quotes', 'Guru Quotes'];
        for($i=0; $i<2; $i++) {
            $quote_category = [
                'status' => '1',
                'visible_on_app' => '1',
                'sequence' => ($i+1),
            ];
            $data = QuoteCategory::firstOrCreate($quote_category);

            foreach (config('translatable.locales') as $locale) {
                $quote_category_translation = [
                    'quote_category_id' => $data->id,
                    'locale' => $locale,
                    'name' => $names[$i],
                ];
                $translation_data = QuoteCategoryTranslation::firstOrCreate($quote_category_translation);
            }
        }
    }
}
