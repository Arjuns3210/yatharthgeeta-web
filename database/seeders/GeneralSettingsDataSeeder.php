<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $general_settings_data = array(
            array('fb_link', 'https://www.facebook.com/yaduz_fashion_fb'),
            array('insta_link', 'https://www.instagram.com/yaduz_fashion_ig'),
            array('twitter_link', 'https://www.twitter.com/yaduz_fashion_tweeter'),
            array('system_email', 'info@mypcot.com'),
            array('system_name', 'YADUZ FASHION'),
            array('system_contact_no', '+91 - 9999999999'),
            array('android_version', '["1.0","1.1","1.2","1.3"]'),
            array('ios_version', '["1.0","1.1","1.2","1.3"]'),
            array('android_url', 'https://www.flipkart.com/vendor'),
            array('ios_url', 'https://www.flipkart.com/vendor'),
        );
        $general_settings = array();
        foreach($general_settings_data as $val){
            array_push($general_settings, array(
                            'type' => $val[0],
                            'value' => $val[1],
                            )
                        );
            }

        foreach($general_settings as $data){
            GeneralSetting::firstOrCreate($data);
        }
    }
}
