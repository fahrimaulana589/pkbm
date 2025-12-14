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
                    'pkbm-profile' => [
                        'title' => 'Profil PKBM',
                        'route_name' => 'admin.pkbm-profile.index'
                    ],
                    'tutor' => [
                        'title' => 'Tutor',
                        'route_name' => 'admin.tutor.index'
                    ],
                    'student' => [
                        'title' => 'Warga Belajar',
                        'route_name' => 'admin.student.index'
                    ],
                ],
                [
                    'program' => [
                        'title' => 'Program Pendidikan',
                        'route_name' => 'admin.program.index'
                    ],
                    'rombel' => [
                        'title' => 'Rombel',
                        'route_name' => 'admin.rombel.index'
                    ],
                    'jadwal' => [
                        'title' => 'Jadwal Belajar',
                        'route_name' => 'admin.jadwal.index'
                    ],
                    'sertifikat' => [
                        'title' => 'Sertifikat',
                        'route_name' => 'admin.sertifikat.index'
                    ],
                ],
                [
                    'announcement' => [
                        'title' => 'Pengumuman',
                        'route_name' => 'admin.pengumuman.index'
                    ],
                    'berita' => [
                        'title' => 'Berita & Artikel',
                        'submenu' => [
                            'kategori' => [
                                'title' => 'Kategori Berita',
                                'route_name' => 'admin.kategori-berita.index'
                            ],
                            'tag' => [
                                'title' => 'Tag Berita',
                                'route_name' => 'admin.tag-berita.index'
                            ],
                            'berita' => [
                                'title' => 'Data Berita',
                                'route_name' => 'admin.berita.index'
                            ],
                        ]
                    ],
                    'galeri' => [
                        'title' => 'Galeri',
                        'route_name' => 'admin.galeri.index'
                    ]
                ]
            ],
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

    public static function ppdb()
    {
        return [
            'title' => 'PPDB',
            'items' => [
                [
                    'ppdb_dashboard' => [
                        'title' => 'Dashboard',
                        'route_name' => 'ppdb.dashboard'
                    ],
                ],
                [
                    'ppdb_ppdb' => [
                        'title' => 'PPDB',
                        'route_name' => 'ppdb.ppdb.index'
                    ],
                    'ppdb_pendaftar' => [
                        'title' => 'Pendaftar',
                        'route_name' => 'ppdb.pendaftar.index'
                    ],
                    'ppdb_info' => [
                        'title' => 'Info PPDB',
                        'route_name' => 'ppdb.info.index'
                    ],
                ]
            ]
        ];
    }

    public static function all(){
        return ['admin' => self::dashboards(), 'setting' => self::settings(), 'ppdb' => self::ppdb()];
    }
}
