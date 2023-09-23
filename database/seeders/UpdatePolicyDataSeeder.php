<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PolicyTranslation;
use App\Models\Policy;

class UpdatePolicyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\DB::table('policies')->delete();
        $policyData = [
            [
                'type'   => 'about',
                'en'       => [
                    'content' => '<p><strong>This is testing about us.</strong></p>'
                ],
                'hi'       => [
                    'content' => '<p><strong>This is testing about us.</strong></p>'
                ],
            ],
            [
                'type' => 'terms',
                'en'       => [
                    'content' => '<p><strong>This is testing terms & conditions.</strong></p>'
                ],
                'hi'       => [
                    'content' => '<p><strong>This is testing terms & conditions.</strong></p>'
                ],
            ],
            [
                'type' => 'policy',
                'en'       => [
                    'content' => '<p><strong>This is testing privacy policy.</strong></p>',
                ],
                'hi'       => [
                    'content' => '<p><strong>This is testing privacy policy.</strong></p>',
                ],
            ],
        ];
        foreach ($policyData as $data){
            Policy::create($data);
        }
    }
}
