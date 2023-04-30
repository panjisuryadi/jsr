<?php

namespace Modules\KategoriBerlian\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {

            // KategoriBerlians
            $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('KategoriBerlians'), [
                'route' => 'kategoriberlian.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 77,
                'activematches' => ['kategoriberlians*'],
                'permission'    => ['access_kategoriberlians'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');











        return $next($request);
    }
}
