<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'company_name' => 'Pos GTDS',
            'company_email' => 'info@official-gtds.com',
            'company_phone' => '012345678901',
            'notification_email' => 'notification@test.com',
            'default_currency_id' => 1,
            'default_currency_position' => 'prefix',
            'bg_sidebar' => '#d8d4d4',
            'bg_sidebar_hover' => '#cb9d30',
            'bg_sidebar_aktif' => '#ffffff',
            'bg_sidebar_link' => '#2a2a2a',
            'bg_sidebar_link_hover' => '#fff',
            'link_color' => '#ffffff',
            'link_hover' => '#cb9d30',
            'header_color' => '#cb9d30',
            'btn_color' => '#cb9d30',
            'footer_text' => 'GTDS Pos © 2021 || Developed by Global tekno digital Solusi',
            'company_address' => 'Bandung, Indonesia'
        ]);
    }
}

