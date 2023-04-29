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
                    'product-categories*',

                ],
                'permission'    => ['create_products', 'access_product_categories', 'access_products'],
            ]);
            $masterData->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: products
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i>Products', [
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

    // Submenu: Categories
            $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i>Categories', [
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





           // Separator: Access Management
            $menu->add('Management', [
                'class' => 'c-sidebar-nav-title text-muted',
            ])
            ->data([
                'order'         => 107,
                'permission'    =>
                   [
                   'access_user_management',
                   'access_settings',
                   'access_currencies'
                   ],
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
