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
                        'title' => 'Analytics',
                        'route_name' => 'dashboard'
                    ],
                    'dashboards_orders' => [
                        'title' => 'Profile',
                        'route_name' => 'profile.edit'
                    ],
                ]
            ]
        ];
    }

    public static function all(){
        return [self::dashboards()];
    }
}
