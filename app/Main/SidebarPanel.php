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
                        'route_name' => 'admin.dashboard'
                    ],
                ],
                [
                    'announcement' => [
                        'title' => 'Pengumuman',
                        'route_name' => 'admin.pengumuman'
                    ],
                    'guru' => [
                        'title' => 'Guru',
                        'route_name' => 'admin.guru'
                    ],
                    'dashboards_orders' => [
                        'title' => 'Profile',
                        'route_name' => 'admin.profile'
                    ],
                ]
            ]
        ];
    }

    public static function settings()
    {
        return [
            'title' => 'Settings',
            'items' => [
                [
                    'setting_email_server' => [
                        'title' => 'Email Server',
                        'route_name' => 'setting.email-server'
                    ],
                ]
            ]
        ];
    }

    public static function all(){
        return ['admin' => self::dashboards(), 'setting' => self::settings()];
    }
}
