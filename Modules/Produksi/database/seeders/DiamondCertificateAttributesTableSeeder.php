<?php

namespace Modules\Produksi\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\DiamondCertificate\Models\DiamondCertificate;
use Modules\Produksi\Models\DiamondCertificateAttributes;

class DiamondCertificateAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Shape and cutting style'],
            [ 'name' => 'Measurement'],
            [ 'name' => 'Carat weight'],
            [ 'name' => 'Color grade'],
            [ 'name' => 'Clarity grade'],
            [ 'name' => 'Cut grade'],
            [ 'name' => 'Polish'],
            [ 'name' => 'Symmentry'],
            [ 'name' => 'Fluroesence'],
            [ 'name' => 'Clarity charateristic'],
            [ 'name' => 'Proportion'],
            [ 'name' => 'Depth'],
            [ 'name' => 'Table diameter'],
            [ 'name' => 'Crown height'],
            [ 'name' => 'Pavilion depth'],
            [ 'name' => 'Gindle thikness']
        ];
        DiamondCertificateAttributes::insert($data);
    }
}
