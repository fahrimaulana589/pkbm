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
                    'tutor' => [
                        'title' => 'Tutor',
                        'route_name' => 'admin.tutor.index'
                    ],
                    'program' => [
                        'title' => 'Program Pendidikan',
                        'route_name' => 'admin.program.index'
                    ],
                    'pkbm-profile' => [
                        'title' => 'Profil PKBM',
                        'route_name' => 'admin.pkbm-profile.index'
                    ],
                    'student' => [
                        'title' => 'Warga Belajar',
                        'route_name' => 'admin.student.index'
                    ],
                    'rombel' => [
                        'title' => 'Rombel',
                        'route_name' => 'admin.rombel.index'
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
