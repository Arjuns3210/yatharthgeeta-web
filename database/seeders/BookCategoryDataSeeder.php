<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookCategory;
use App\Models\BookCategoryTranslation;

class BookCategoryDataSeeder extends Seeder
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
            $book_category = [
                'status' => '1',
                'sequence' => ($names[$i] === 'Others') ? 99 : ($i+1),
            ];
            $data = BookCategory::firstOrCreate($book_category);

            foreach (config('translatable.locales') as $locale) {
                $book_category_translation = [
                    'book_category_id' => $data->id,
                    'locale' => $locale,
                    'name' => $names[$i],
                ];
                $translation_data = BookCategoryTranslation::firstOrCreate($book_category_translation);
            }
        }
    }
}
