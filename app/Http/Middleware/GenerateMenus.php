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
                '<i class="text-sm c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('labels.menu.categories'), [
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
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('labels.menu.kategori_produk'), [
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


      // JenisGroups
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Jenis Group'), [
                'route' => 'jenisgroup.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['jenisgroups*'],
                'permission'    => ['access_jenisgroups'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link  py-',
            ]);


     // Groups
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Group'), [
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


            // DataSales
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Data Sales'), [
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

        // MarketPlaces
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Market Place'), [
                'route' => 'marketplace.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['marketplaces*'],
                'permission'    => ['access_marketplaces'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);




   // DiamondCertificates
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('labels.menu.diamond_certificate'), [
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



            // gudang
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Gudang'), [
                'route' => 'gudang.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['gudangs*'],
                'permission'    => ['access_gudangs'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link  py-2',
            ]);




            // Bakis
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Baki'), [
                'route' => 'baki.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['bakis*'],
                'permission'    => ['access_bakis'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


            // Bandrols
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Bandrol'), [
                'route' => 'bandrol.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['bandrols*'],
                'permission'    => ['access_bandrols'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);

        // Karats
            $masterData->add(
                '<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('labels.menu.carat'), [
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


          $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Rounds'), [
                'route' => 'itemround.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => 'itemrounds*',
                'permission'    => ['access_itemrounds'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


            // ItemShapes
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Shapes'), [
                'route' => 'itemshape.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['itemshapes*'],
                'permission'    => ['access_itemshapes'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2',
            ]);


             $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Colours'), [
                'route' => 'itemcolour.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 3,
                'activematches' => ['itemcolours*'],
                'permission'    => ['access_itemcolours'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link py-2 pb-3',
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
                'class' => 'c-sidebar-nav-link py-2',
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
                'class' => 'c-sidebar-nav-link py-2 pb-3',
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
                'class' => 'c-sidebar-nav-link py-3',
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
                'class' => 'c-sidebar-nav-link py-2 pb-3',
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
