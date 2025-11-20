<?php

namespace App\Main;


class SidebarPanel
{
    public static function dashboards()
    {
        return [
            'title' => 'Dashboards',
            'items' => [
                [
                    'dashboards_crm_analytics' => [
                        'title' => 'CRM Analytics',
                        'route_name' => 'dashboard'
                    ],
                    'dashboards_orders' => [
                        'title' => 'Orders',
                        'route_name' => 'dashboard'
                    ],
                ]
            ]
        ];
    }

    public static function all(){
        return [self::dashboards()];
    }
}
