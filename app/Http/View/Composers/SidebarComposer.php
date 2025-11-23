<?php

namespace App\Http\View\Composers;

use App\Main\SidebarPanel;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!is_null(request()->route())) {
            $pageName = request()->route()->getName();
            $routePrefix = explode('.', $pageName)[0] ?? '';
            switch ($routePrefix) {
                case 'admin':
                    $view->with('sidebarMenu', SidebarPanel::dashboards());
                    break;
                case 'setting':
                    $view->with('sidebarMenu', SidebarPanel::settings());
                    break;
                default:
                    $view->with('sidebarMenu', SidebarPanel::dashboards());
            }
            
            $view->with('allSidebarItems', SidebarPanel::all());
            $view->with('pageName', $pageName);
            $view->with('routePrefix', $routePrefix);
        }
    }
}
