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
                                      'access_itemshapes',
                                      'access_karats',
                                      'access_kategoriproduks',
                                      'access_diamondcertificates',
                                      'access_products'],
            ]);
            $masterData->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


   // JenisProduks
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('labels.menu.categories'), [
                'route' => 'kategoriproduk.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['kategoriproduk*'],
                'permission'    => ['access_kategoriproduks'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);





    // Submenu: Categories
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('labels.menu.kategori_produk'), [
                'route' => 'product-categories.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'product-categories*',
                'permission'    => ['access_product_categories'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


   // DiamondCertificates
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('labels.menu.diamond_certificate'), [
                'route' => 'diamondcertificate.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['diamondcertificates*'],
                'permission'    => ['access_diamondcertificates'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

        // Karats
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('labels.menu.carat'), [
                'route' => 'karat.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['karats*'],
                'permission'    => ['access_karats'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


          $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('Rounds'), [
                'route' => 'itemround.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'itemrounds*',
                'permission'    => ['access_itemrounds'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


            // ItemShapes
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('Shapes'), [
                'route' => 'itemshape.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['itemshapes*'],
                'permission'    => ['access_itemshapes'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);


      //============================Access Control Dropdown
            $products = $menu->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Products', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
                'activematches' => [
                    'products*',


                ],
                'permission' => ['create_products',
                                      'print_barcodes',
                                      'access_products'],
            ]);
            $products->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


       // Submenu: products
            $products->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('List Products').'',
                 [
                'route' => 'products.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'products*',
                'permission'    => ['access_products'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

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
                'class' => 'c-sidebar-nav-link',
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


      //============================Access Control Dropdown
            $adjustments = $menu->add('
                <i class="mb-2 c-sidebar-nav-icon bi bi-clipboard-check"></i> '.__('Adjustments').'',
                 [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 2,
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
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('List Adjustments').'',
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
                'class' => 'c-sidebar-nav-link',
            ]);

  // Submenu: adjustments
            $adjustments->add('
                <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('Create Adjustments').'',
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
                'class' => 'c-sidebar-nav-link',
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
            $report->add('<i class="c-sidebar-nav-icon bi bi-cash-coin"></i> '.__('Profit Loss Report').'', [
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
            $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2"></i> '.__('Payments Report').'', [
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


 // Submenu: Users
            $report->add('<i class="c-sidebar-nav-icon bi bi-bag-check"></i> '.__('Sales Report').'', [
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
            $report->add('<i class="c-sidebar-nav-icon bi bi-receipt"></i> '.__('Purchases Report').'', [
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
            $report->add('<i class="c-sidebar-nav-icon bi bi-bag-fill"></i> '.__('Sales Return Report').'', [
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
            $report->add('<i class="c-sidebar-nav-icon bi bi-bag-x"></i> '.__('Purchases Return Report').'', [
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
