<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {
            // Dashboard
            $menu->add('<i class="cil-speedometer c-sidebar-nav-icon"></i> Dashboard', [
                'route' => 'home',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 1,
                'activematches' => 'home*',
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);




            // Access Control Dropdown
            $masterData = $menu->add('<i class="c-sidebar-nav-icon cil-apps"></i> Master Data', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'products*',
                    'kategoriproduk*',
                    'product-categories*',
                    'diamondcertificates*',
                    'itemrounds*',
                    'itemshapes*',

                ],
                'permission' => ['create_products',
                                      'access_product_categories',
                                      'access_itemrounds',
                                      'access_masterdata',
                                      'access_itemshapes',
                                      'access_karats',
                                      'access_kategoriproduks',
                                      'access_diamondcertificates',
                                      'itemclarities',
                                      'access_products'],
            ]);
            $masterData->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


 //==== Access Control Dropdown Categories
         $Categories = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('labels.menu.categories'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'kategoriproduk*',
                ],
                'permission' => ['access_kategoriproduks'],
            ]);
            $Categories->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


   // Main Kategori
            $Categories->add(
                '<i class="px-1 text-sm c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Main Kategori'), [
                'route' => 'kategoriproduk.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['kategoriproduk*'],
                'permission'    => ['access_kategoriproduks'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

    // Submenu: Categories
            $Categories->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('labels.menu.kategori_produk'), [
                'route' => 'product-categories.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'product-categories*',
                'permission'    => ['access_product_categories'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


   // GoldCategories
            $Categories->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Gold Categories'), [
                'route' => 'goldcategory.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['goldcategories*'],
                'permission'    => ['access_goldcategories'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


    // JenisPerhiasans
            $Categories->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Jenis Perhiasan'), [
                'route' => 'jenisperhiasan.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['jenisperhiasans*'],
                'permission'    => ['access_jenisperhiasans'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);





    // DiamondCertificates
            $Categories->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('labels.menu.diamond_certificate'), [
                'route' => 'diamondcertificate.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['diamondcertificates*'],
                'permission'    => ['access_diamondcertificates'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);



//=========================== end menu kategori

 //==== Access Control Dropdown Categories
         $jenisGropus = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Group'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'jenisgroups*',
                    'groups*',
                ],
                'permission' => ['access_jenisgroups','access_groups'],
            ]);
            $jenisGropus->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);



      // JenisGroups
            $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Jenis Group'), [
                'route' => 'jenisgroup.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['jenisgroups*'],
                'permission'    => ['access_jenisgroups'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


             // Groups
            $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Group'), [
                'route' => 'group.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['groups*'],
                'permission'    => ['access_groups'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


         // JenisBuyBacks
        $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Jenis Buy Backs'), [
                'route' => 'jenisbuyback.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['jenisbuybacks*'],
                'permission'    => ['access_jenisbuybacks'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

            // Cabangs
            $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Cabang'), [
                'route' => 'cabang.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['cabangs*'],
                'permission'    => ['access_cabangs'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);




/// === end menu group --------------------------------------------------




 //==== Access Control Dropdown data master
         $dataMaster = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Data Master'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'datarekenings*',
                    'datasales*',
                    'datarekenings*',
                    'dataetalases*',
                    'kodetransaksis*',
                    'marketplaces*',
                    'access_produkmodels*',
                ],
                'permission' => [
                                   'access_datasales',
                                   'access_datarekenings',
                                   'access_datarekenings',
                                   'access_marketplaces',
                                   'access_kodetransaksis',
                                   'access_produkmodels',
                                    'access_dataetalases'
                                ],
            ]);
            $dataMaster->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // ProdukModels
            $dataMaster->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Produk Models'), [
                'route' => 'produkmodel.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['produkmodels*'],
                'permission'    => ['access_produkmodels'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


        
            // DataEtalases
        

//================ end menu data master ----------------------





 //==== Access Control Dropdown data Parameter
         $Parameters = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Data Parameters'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'paramaterpoins*',
                    'goldparameters*',
                    'costparameters*',
                    'databanks*',

                ],
                'permission' => [
                                   'access_paramaterpoins',
                                   'access_goldparameters',
                                   'costparameters',
                                   'access_databanks'],
            ]);
            $Parameters->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);



       // ParamaterPoins
            
        // Karats
            $Parameters->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Karat Emas'), [
                'route' => 'karat.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['karats*'],
                'permission'    => ['access_karats'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);









    //end master parameter
 //==== Access Control Status Iventory
         



//end status iventory====



 //==== Access Control Dropdown Gudang
         

// end gudang menu =======================






// pembelian
            $Purchases = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-journal-check"></i>'.__('Purchases').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'purchase-payments*',

                ],
                'permission'    => ['access_purchases'],
            ]);
            $Purchases->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

          // GoodsReceipts
     $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Goods Receipts'), [
                'route' => 'goodsreceipt.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 2,
                'activematches' => ['goodsreceipts*'],
                'permission'    => ['access_goodsreceipts'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

       // Riwayat Penerimaan
     $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i>
                '.__('Riwayat Penerimaan'), [
                'route' => 'goodsreceipt.riwayat_penerimaan',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 2,
                'activematches' => ['goodsreceipts*'],
                'permission'    => ['access_goodsreceipts'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);








      //============================Access Control Dropdown
$products = $menu->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Inventory', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 3,
                'activematches' => [
                    'products*',
                    'penentuanhargas*',
                    'datasales*',
                ],
                'permission' => ['create_products',
                                      'print_barcodes',
                                      'access_product_transfer',
                                      'access_timbangans',
                                      'access_penentuanhargas',
                                      'access_datasales',
                                      'access_products'],
            ]);
            $products->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


       // Submenu: iventory
            $products->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>
                '.__('List Inventory').'',
                 [
                'route' => 'iventory.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'iventories*',
                'permission'    => ['access_iventories'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

          





      $products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i>
     '.__('Penentuan Harga'), [
                'route' => 'penentuanharga.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['penentuanhargas*'],
                'permission'    => ['access_penentuanhargas'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);



           



            // // Submenu: products
            // $products->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('Products Transfer').'',
            //      [
            //     'route' => 'product-transfer.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 3,
            //     'activematches' => 'product-transfer*',
            //     'permission'    => ['access_product_transfer'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

  // PenentuanHargas


    // Timbangans
    // $products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Timbangan'), [
    //             'route' => 'timbangan.index',
    //             'class' => 'nav-item',
    //         ])
    //         ->data([
    //             'order'         => 3,
    //             'activematches' => ['timbangans*'],
    //             'permission'    => ['access_timbangans'],
    //         ])
    //         ->link->attr([
    //             'class' => 'c-sidebar-nav-link py-2',
    //         ]);




       // Submenu: products
            $products->add(
                '<i class="c-sidebar-nav-icon bi bi-upc-scan mb-2"></i>'.__('Print Barcode').'',
             [
                'route' => 'barcode.print',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'barcode*',
                'permission'    => ['print_barcodes'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);



          // Submenu: SORTIR
            $products->add(
                '<i class="c-sidebar-nav-icon bi bi-credit-card-2-back mb-2"></i>'.__('Sortir').'',
             [
                'route' => 'products.sortir',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'sortir*',
                'permission'    => ['access_products'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);



          // Submenu: Gudang Utama


          // Submenu: Reparasi
            $products->add(
                '<i class="c-sidebar-nav-icon bi bi-tools mb-2"></i>'.__('Reparasi').'',
             [
                'route' => 'products.reparasi',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'reparasi*',
                'permission'    => ['access_products'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);





         // Access Control Dropdown Stok
         $stok = $menu->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Stok', [
                        'class' => 'c-sidebar-nav-dropdown',
                    ])
                    ->data([
                        'order'         => 3,
                        'activematches' => [
                                   'stoks*',
                                  ],
                          'permission' => ['create_products',
                                             'access_stoks'],
                    ]);
                    $stok->link->attr([
                        'class' => 'c-sidebar-nav-dropdown-toggle',
                        'href'  => '#',
                    ]);

                    // DataStok
                    $stok->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Stock Sales'), [
                        'route' => 'stok.index',
                        'class' => 'nav-item',
                    ])
                    ->data([
                        'order'         => 3,
                        'activematches' => ['stoks*'],
                        'permission'    => ['access_stoks'],
                    ])
                    ->link->attr([
                        'class' => 'c-sidebar-nav-link py-2',
                    ]);

                  // DataStok
                    $stok->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Stock Office'), [
                        'route' => 'stok.index',
                        'class' => 'nav-item',
                    ])
                    ->data([
                        'order'         => 3,
                        'activematches' => ['stoks*'],
                        'permission'    => ['access_stoks'],
                    ])
                    ->link->attr([
                        'class' => 'c-sidebar-nav-link py-2',
                    ]);

                  // DataStok
                    $stok->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Stock Pending'), [
                        'route' => 'stok.index',
                        'class' => 'nav-item',
                    ])
                    ->data([
                        'order'         => 3,
                        'activematches' => ['stoks*'],
                        'permission'    => ['access_stoks'],
                    ])
                    ->link->attr([
                        'class' => 'c-sidebar-nav-link py-2',
                    ]);




                  // DataStok
                    $stok->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Stock DP'), [
                        'route' => 'stok.index',
                        'class' => 'nav-item',
                    ])
                    ->data([
                        'order'         => 3,
                        'activematches' => ['stoks*'],
                        'permission'    => ['access_stoks'],
                    ])
                    ->link->attr([
                        'class' => 'c-sidebar-nav-link py-2',
                    ]);



                  // DataStok
                    $stok->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Stock Kroom'), [
                        'route' => 'stok.index',
                        'class' => 'nav-item',
                    ])
                    ->data([
                        'order'         => 3,
                        'activematches' => ['stoks*'],
                        'permission'    => ['access_stoks'],
                    ])
                    ->link->attr([
                        'class' => 'c-sidebar-nav-link py-2',
                    ]);







   // distribusitokos Access Control Dropdown ==================================
            $distribusiToko = $menu->add(
                '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
                '.__('Distribusi Toko').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 3,
                'activematches' => [
                    'datasales*',
                    'distribusitokos*',

                ],
                'permission'    => ['access_distribusitoko'],
            ]);
            $distribusiToko->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // DistribusiTokos
            $distribusiToko->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('List Distribusi Toko'), [
                'route' => 'distribusitoko.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['distribusitokos*'],
                'permission'    => ['access_distribusitoko'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);




         // distribusitokos Access Control Dropdown ==================================
            $distribusisales = $menu->add(
                '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
                '.__('Distribusi Sales').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 3,
                'activematches' => [
                    'datasales*',
                    'distribusitokos*',
                    'penjualansales*',

                ],
                'permission'    => ['access_penjualansales',
                'access_distribusisales','access_datasales'],
            ]);
            $distribusisales->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);




       // DistribusiSales
            $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('List Distribusi Sales'), [
                'route' => 'distribusisale.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['distribusisales*'],
                'permission'    => ['access_distribusisales'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

            // DataSales
            $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Data Sales'), [
                'route' => 'datasale.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['datasales*'],
                'permission'    => ['access_datasales'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);



     // PenjualanSales
     $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Penjualan Sales'), [
                'route' => 'penjualansale.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['penjualansales*'],
                'permission'    => ['access_penjualansales'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);
      


          // ReturSales
            $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Retur Sales'), [
                'route' => 'retursale.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['retursales*'],
                'permission'    => ['access_retursales'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


      

            // customers Access Control Dropdown ==================================
            $access_expenses = $menu->add(
                '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
                '.__('labels.menu.expense').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 77,
                'activematches' => [
                    'expense*',

                ],
                'permission'    => ['access_expenses','access_expense_categories'],
            ]);
            $access_expenses->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


     // Submenu: expenses
            $access_expenses->add(
                '<i class="c-sidebar-nav-icon bi bi-journal-arrow-up mb-1"></i>
                 '.__('labels.menu.expense_list').'', [
                'route' => 'expenses.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 77,
                'activematches' => 'expenses*',
                'permission'    => ['access_expenses'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-3 mt-1',
            ]);


            // Submenu: expense_categories
            $access_expenses->add(
                '<i class="c-sidebar-nav-icon bi bi-journal-bookmark-fill mb-1"></i>
                 '.__('labels.menu.expense_categories').'', [
                'route' => 'expense-categories.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 77,
                'activematches' => 'expense-categories*',
                'permission'    => ['access_expense_categories'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-3',
            ]);


            // customers Access Control Dropdown ==================================
            $customers = $menu->add(
                '<i class="c-sidebar-nav-icon mb-1 bi bi-people-fill"></i>
                '.__('labels.menu.people').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 78,
                'activematches' => [
                    'customers*',

                ],
                'permission'    => ['access_customers','access_suppliers'],
            ]);
            $customers->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: customers
            $customers->add(
                '<i class="c-sidebar-nav-icon bi bi-person-square mb-1"></i>
                 '.__('customers').'', [
                'route' => 'customers.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 1,
                'activematches' => 'customers*',
                'permission'    => ['access_customers'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-3',
            ]);
     // Submenu: customers
            $customers->add(
                '<i class="c-sidebar-nav-icon bi bi-person-bounding-box mb-1"></i>
                 '.__('Suppliers').'', [
                'route' => 'suppliers.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 1,
                'activematches' => 'suppliers*',
                'permission'    => ['access_suppliers'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-3',
            ]);


           // Separator: Access Management
            $menu->add('Management', [
                'class' => 'c-sidebar-nav-title text-gray-100',
            ])
            ->data([
                'order'         => 89,
                'permission'    =>
                   [
                   'access_user_management',
                   'access_settings',
                   'access_currencies'
                   ],
            ]);


      //============================Access Control adjustments
            $adjustments = $menu->add('
                <i class="mb-2 c-sidebar-nav-icon bi bi-clipboard-check"></i> '.__('Adjustments').'',
                 [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 3,
                'activematches' => [
                    'adjustments*',


                ],
                'permission' => ['access_adjustments',
                                     // 'print_barcodes',
                                      'create_adjustments'],
            ]);
            $adjustments->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


       // Submenu: adjustments
            $adjustments->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-1"></i>'.__('List Adjustments').'',
                 [
                'route' => 'adjustments.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'adjustments*',
                'permission'    => ['create_adjustments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-3',
            ]);

  // Submenu: adjustments
            $adjustments->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-1"></i>'.__('Create Adjustments').'',
                 [
                'route' => 'adjustments.create',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'adjustments*',
                'permission'    => ['create_adjustments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);


  // Submenu: adjustments
            $adjustments->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('Stocks').'',
                 [
                'route' => 'stocks.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'stocks*',
                'permission'    => ['create_adjustments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);


       $adjustments->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>
                '.__('Stock Transfer').'',
                 [
                'route' => 'stocktransfer.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'stocktransfer*',
                'permission'    => ['create_adjustments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);


             $adjustments->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>
                '.__('Stok RFID').'',
                 [
                'route' => 'rfid.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'rfid*',
                'permission'    => ['create_adjustments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-2',
            ]);





          






    // Access Purchases Dropdown
            $purchaseReturns = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-journal-check"></i>'.__('Purchase Returns').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 4,
                'activematches' => [
                    'purchase-returns.*',
                    'purchase-return-payments.*',

                ],
                'permission'    => ['access_purchase_returns'],
            ]);
            $purchaseReturns->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


            // Submenu: Purchase Return
            $purchaseReturns->add('<i class="c-sidebar-nav-icon bi bi-cash-coin mb-1"></i>
             '.__('Purchase Return').'', [
                'route' => 'purchase-returns.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 4,
                'permission'    => ['create_purchase'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

           // BuysBacks
            $purchaseReturns->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i>
                '.__('Buys Backs'), [
                'route' => 'buysback.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 4,
                'activematches' => ['buysbacks*'],
                'permission'    => ['access_buysbacks'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);




             // Access Control Dropdown
            $report = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-journal-check"></i>'.__('Reports').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 88,
                'activematches' => [
                    '*-report.index',

                ],
                'permission'    => ['access_reports'],
            ]);
            $report->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


            // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-cash-coin mb-1"></i> '.__('Profit Loss Report').'', [
                'route' => 'profit-loss-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


   // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2 mb-1"></i> '.__('Payments Report').'', [
                'route' => 'payments-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

          // Submenu: laporan Piutang
            $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2 mb-1"></i> '.__('laporan Piutang').'', [
                'route' => 'piutang-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

          // Submenu: laporan hutang
            $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2 mb-1"></i> '.__('Hutang').'', [
                'route' => 'hutang-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


 // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-bag-check mb-2"></i> '.__('Sales Report').'', [
                'route' => 'sales-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

 // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-receipt mb-2"></i> '.__('Purchases Report').'', [
                'route' => 'purchases-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


 // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-bag-fill mb-2"></i> '.__('Sales Return Report').'', [
                'route' => 'sales-return-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);



 // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-bag-x mb-2"></i> '.__('Purchases Return Report').'', [
                'route' => 'purchases-return-report.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 88,
                'permission'    => ['access_reports'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


 // Access Control Dropdown
            $setting = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-gear"></i>'.__('Setting').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 90,
                'activematches' => [
                    'currencies*',

                ],
                'permission'    => ['access_currencies','access_settings'],
            ]);
            $setting->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users

            $setting->add('<i class="c-sidebar-nav-icon bi bi-currency-exchange"></i> '.__('currencies').'', [
                'route' => 'currencies.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 91,
                'activematches' => 'currencies*',
                'permission'    => ['access_currencies'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


          $setting->add('<i class="c-sidebar-nav-icon bi-sliders"></i> '.__('System Settings').'', [
                'route' => 'settings.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 91,
                'activematches' => 'settings*',
                'permission'    => ['access_settings'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);




   // Access Control Dropdown
            $accessControl = $menu->add('<i class="c-sidebar-nav-icon cil-people"></i>'.__('Users Management').'', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 101,
                'activematches' => [
                    'users*',

                ],
                'permission'    => ['access_user_management'],
            ]);
            $accessControl->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users

            $accessControl->add('<i class="c-sidebar-nav-icon cil-people"></i> '.__('Users').'', [
                'route' => 'users.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => 'users*',
                'permission'    => ['access_user_management'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

         $accessControl->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Roles').'', [
                'route' => 'roles.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => 'roles*',
                'permission'    => ['access_user_management'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


             // UserCabangs
            $accessControl->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('User Cabang'), [
                'route' => 'usercabang.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => ['usercabangs*'],
                'permission'    => ['access_usercabangs'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

           // UserLogins
            $accessControl->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('User Login'), [
                'route' => 'userlogin.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => ['userlogins*'],
                'permission'    => ['access_userlogins'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

            // Companies
            $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Company'), [
                'route' => 'company.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => ['companies*'],
                'permission'    => ['access_companies'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


        // LogActivities
            $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Log Activities'), [
                'route' => 'logactivity.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => ['logactivities*'],
                'permission'    => ['access_logactivities'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);



            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (auth()->user()->hasRole('Super Admin')) {
                            return true;
                        } elseif (auth()->user()->hasAnyPermission($item->data('permission'))) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            });

            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $matches = is_array($item->activematches) ? $item->activematches : [$item->activematches];

                    foreach ($matches as $pattern) {
                        if (Str::is($pattern, \Request::path())) {
                            $item->activate();
                            $item->active();
                            if ($item->hasParent()) {
                                $item->parent()->activate();
                                $item->parent()->active();
                            }
                            // dd($pattern);
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}
