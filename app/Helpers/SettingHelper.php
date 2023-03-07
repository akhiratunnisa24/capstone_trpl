<!-- <php 

namespace App\Helper;

use App\Models\SettingOrganisasi;

class SettingHelper
{
    function getSetting()
    {
        $settingOrganisasi = SettingOrganisasi::get()->first();
        return $settingOrganisasi;
    }
} -->
<?php

if (!function_exists('getSetting')) {
    /**
     * Get the path of the organisasi's logo
     *
     * @return string|null The path of the logo or null if it does not exist
     */
    function getSetting()
    {
        $settingOrganisasi = App\Models\SettingOrganisasi::first();
        if ($settingOrganisasi && !empty($settingOrganisasi->logo)) {
            return asset('images/' . $settingOrganisasi->logo);
        }
        return null;
    }
}
