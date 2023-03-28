<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $tabSettings = $this->getSettings();

        foreach($tabSettings as $tab => $settings) {

            $order = 1;

            foreach ($settings as $key => $setting) {

                $setting['group'] = $tab;
                $setting['order'] = $order++;
                $settingModel = $this->findSetting($key);

                if (!$settingModel->exists) {
                    $settingModel->fill($setting)->save();
                } else {
                    $settingModel->update([
                        'display_name' => $setting['display_name'],
                        'group' => $setting['group'],
                        'order' => $setting['order'],
                    ]);
                }
            }
        }


    }

    /**
     * Settings Details
     *
     * @return array [setting details]
     */
    protected function getSettings() {

        return [
            'Site' => [
                'site.title' => [
                    'display_name' => __('voyager::seeders.settings.site.title'),
                    'value'        => __('voyager::seeders.settings.site.title'),
                    'details'      => '',
                    'type'         => 'text',
                ],
                'site.description' => [
                    'display_name' => __('voyager::seeders.settings.site.description'),
                    'value'        => __('voyager::seeders.settings.site.description'),
                    'details'      => '',
                    'type'         => 'text',
                ],
                'site.logo' => [
                    'display_name' => __('voyager::seeders.settings.site.logo'),
                    'value'        => '',
                    'details'      => '',
                    'type'         => 'image',
                ],
                'site.google_analytics_tracking_id' => [
                    'display_name' => __('voyager::seeders.settings.site.google_analytics_tracking_id'),
                    'value'        => '',
                    'details'      => '',
                    'type'         => 'text',
                ],
            ],
            'Admin' => [
                'admin.bg_image' => [
                    'display_name' => __('voyager::seeders.settings.admin.background_image'),
                    'value'        => '',
                    'details'      => '',
                    'type'         => 'image',
                ],
                'admin.title' => [
                    'display_name' => __('voyager::seeders.settings.admin.title'),
                    'value'        => 'Voyager',
                    'details'      => '',
                    'type'         => 'text',
                ],
                'admin.description' => [
                    'display_name' => __('voyager::seeders.settings.admin.description'),
                    'value'        => __('voyager::seeders.settings.admin.description_value'),
                    'details'      => '',
                    'type'         => 'text',
                ],
                'admin.loader' => [
                    'display_name' => __('voyager::seeders.settings.admin.loader'),
                    'value'        => '',
                    'details'      => '',
                    'type'         => 'image',
                ],
                'admin.icon_image' => [
                    'display_name' => __('voyager::seeders.settings.admin.icon_image'),
                    'value'        => '',
                    'details'      => '',
                    'type'         => 'image',
                ],
                'admin.google_analytics_client_id' => [
                    'display_name' => __('voyager::seeders.settings.admin.google_analytics_client_id'),
                    'value'        => '',
                    'details'      => '',
                    'type'         => 'text',
                ]
            ]
        ];
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
