<?php

namespace App\Http\Livewire\DistribusiToko;

use Livewire\Component;
use Modules\Product\Entities\Category;

class Create extends Component
{

    public $categories;
    public $product_category;

    public $cabang;

    public $distribusi_toko = [
        'date' => '',
        'cabang_id' => ''
    ];

    public $distribusi_toko_details = [
        [
            'product_category' => '',
            'grup' => '',
            'model' => '',
            'gold_category' => '',
            'karat' => '',
            'accessoris_weight' => '',
            'label_weight' => '',
            'gold_weight' => '',
            'total_weight' => '',
            'code' => '',
            'file' => '',
            'certificate_id' => '',
            'no_certificate' => ''
        ]
    ];


    public function add()
    {
        $this->distribusi_toko_details[] = [
            'product_category' => '',
            'grup' => '',
            'model' => '',
            'gold_category' => '',
            'karat' => '',
            'accessoris_weight' => '',
            'label_weight' => '',
            'gold_weight' => '',
            'total_weight' => '',
            'code' => '',
            'file' => '',
            'certificate_id' => '',
            'no_certificate' => ''
        ];
    }

    private function resetDistribusiToko()
    {
        $this->distribusi_toko = [
            'date' => '',
            'cabang_id' => ''
        ];
    }
    private function resetDistribusiTokoDetails()
    {
        $this->distribusi_toko_details = [
            [
                'product_category' => '',
                'grup' => '',
                'model' => '',
                'gold_category' => '',
                'karat' => '',
                'accessoris_weight' => '',
                'label_weight' => '',
                'gold_weight' => '',
                'total_weight' => '',
                'code' => '',
                'file' => '',
                'certificate_id' => '',
                'no_certificate' => ''
            ]
        ];
    }

    public function render(){
        return view('livewire.distribusi-toko.create');
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->distribusi_toko_details[$key]);
        $this->distribusi_toko_details = array_values($this->distribusi_toko_details);
    }
}
