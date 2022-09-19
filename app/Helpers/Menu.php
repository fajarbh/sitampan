<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class Menu
{

    public static function generateUserMenu($roleId) {
        $menus  = [
            [
                'title' =>  'Dashboard',
                'slug'  =>  'dashboard',
                'icon'  =>  'home',
                'allowed_role_id' => [1,2,3,4]
            ],
            [
                'title' =>  'User Data',
                'slug'  =>  'akun',
                'icon'  =>  'users',
                'submenus' => [
                    [
                        'title' =>  'User',
                        'slug'  =>  'akun',
                        'allowed_role_id' => [1]
                    ],
                    [
                        'title' =>  'Pendaftaran Petani',
                        'slug'  =>  'pendaftaran-petani',
                        'allowed_role_id' => [1,3]
                    ],
                    [
                        'title' =>  'Pendaftaran Penyuluh',
                        'slug'  =>  'pendaftaran-penyuluh',
                        'allowed_role_id' => [1]
                    ],
                ],
                'allowed_role_id' => [1,3]
            ],
            [
                'title' =>  'Master Data',
                'slug'  =>  '#',
                'icon'  =>  'database',
                'submenus' => [
                    [
                        'title' =>  'Data Desa',
                        'slug'  =>  'desa',
                        'allowed_role_id' => [1]
                    ],
                    [
                        'title' =>  'Data Kecamatan',
                        'slug'  =>  'kecamatan',
                        'allowed_role_id' => [1]
                    ],
                    [
                        'title' =>  'Data Jenis Komoditas',
                        'slug'  =>  'jenis-komoditas',
                        'allowed_role_id' => [1]
                    ],
                    [
                        'title' =>  'Data Komoditas',
                        'slug'  =>  'komoditas',
                        'allowed_role_id' => [1]
                    ],
                    // [
                    //     'title' =>  'Data Komoditas Petani',
                    //     'slug'  =>  'komoditas-petani',
                    //     'allowed_role_id' => [1]
                    // ],
                    [
                        'title' =>  'Data Kelompok Tani',
                        'slug'  =>  'kelompok-tani',
                        'allowed_role_id' => [1]
                    ],
                    [
                        'title' =>  'Data Komoditas Pengepul',
                        'slug'  =>  'komoditas-pengepul',
                        'allowed_role_id' => [1,2]
                    ]

                ],
                'allowed_role_id' => [1,2]
            ],
            [
                'title' =>  'Pengelolaan Tanam',
                'slug'  =>  'tanam',
                'icon'  =>  'users',
                'allowed_role_id' => [3]
            ],
            [
                'title' =>  'Pengelolaan Panen',
                'slug'  =>  'panen',
                'icon'  =>  'users',
                'allowed_role_id' => [3]
            ],
            [
                'title' =>  'Pengelolaan Panen',
                'slug'  =>  'panen',
                'icon'  =>  'users',
                'submenus' => [
                    [
                        'title' =>  'Data Harga Pasar',
                        'slug'  =>  'harga-pasar',
                        'allowed_role_id' => [2]
                    ],
                ],
                'allowed_role_id' => [2]
            ],
            [
                'title' =>  'Pengelolaan Pengepul',
                'slug'  =>  'pengepul',
                'icon'  =>  'users',
                'allowed_role_id' => [1,2]
            ],
            [
                'title' =>  'Berita',
                'slug'  =>  'berita',
                'icon'  =>  'image',
                'allowed_role_id' => [1,3]
            ],
            [
                'title' => 'Laporan',
                'slug' => 'laporan',
                'icon' => 'file-text',
                'submenus' => [
                    [
                        'title' => 'Tambah Tanam',
                        'slug' => 'laporan-tambah-tanam',
                        'allowed_role_id' => [1]
                    ],
                ],
                'allowed_role_id' => [1]
            ],
            [
                'title' =>  'Log',
                'slug'  =>  'log',
                'icon'  =>  'archive',
                'allowed_role_id' => [1]
            ],
        ];

        return self::filterMenuByRole($menus, $roleId);
    }

    public static function filterMenuByRole($menus, $role_id)
    {
        $filtered_menus	= [];
        foreach ($menus as $menu_index => $menu) {
            $is_menu_allowed = array_filter(
                $menu["allowed_role_id"],
                function ($value) use ($role_id) {
                    return $value == $role_id;
                }
            );

            if ( ! empty($is_menu_allowed)) {
                $filtered_menus[$menu_index] = [
                    'title' =>  $menu['title'],
                    'slug'  =>  $menu['slug'],
                    'icon'  =>  $menu['icon'],
                    'allowed_role_id' => $menu['allowed_role_id']
                ];
            }

            if (isset($menu['submenus'])) {
                foreach ($menu['submenus'] as $submenu_index => $submenu) {
                    $is_submenu_allowed	= array_filter(
                        $submenu["allowed_role_id"],
                        function ($value) use ($role_id) {
                            return $value == $role_id;
                        }
                    );

                    if ( ! empty($is_submenu_allowed)) {
                        $filtered_menus[$menu_index]['submenus'][$submenu_index] = [
                            'title' =>  $submenu['title'],
                            'slug'  =>  $submenu['slug'],
                            'allowed_role_id' => $submenu['allowed_role_id'],
                        ];
                    }
                }
            }
        }

        return $filtered_menus;
    }
}