<?php

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Menu;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username' => 'admin',
            'password' => bcrypt('antto2021'),
            'name'     => 'Administrator',
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission
        Permission::truncate();
        Permission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
            [
                'name'        => 'Dashboard',
                'slug'        => 'dashboard',
                'http_method' => 'GET',
                'http_path'   => '/',
            ],
            [
                'name'        => 'Login',
                'slug'        => 'auth.login',
                'http_method' => '',
                'http_path'   => "/auth/login\r\n/auth/logout",
            ],
            [
                'name'        => 'User setting',
                'slug'        => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path'   => '/auth/setting',
            ],
            [
                'name'        => 'Auth management',
                'slug'        => 'auth.management',
                'http_method' => '',
                'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
            ],
        ]);

        Role::first()->permissions()->save(Permission::first());

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '?????????',
                'icon'      => 'fa-dashboard',
                'uri'       => '/',
            ],
            [
                'parent_id' => 0,
                'order'     => 14,
                'title'     => '????????????',
                'icon'      => 'fa-tasks',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => '?????????',
                'icon'      => 'fa-users',
                'uri'       => 'auth/users',
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => '??????',
                'icon'      => 'fa-user',
                'uri'       => 'auth/roles',
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => '??????',
                'icon'      => 'fa-ban',
                'uri'       => 'auth/permissions',
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => '??????',
                'icon'      => 'fa-bars',
                'uri'       => 'auth/menu',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => '????????????',
                'icon'      => 'fa-history',
                'uri'       => 'auth/logs',
            ],
            [
                'parent_id' => 2,
                'order'     => 8,
                'title'     => '????????????',
                'icon'      => 'fa-commenting',
                'uri'       => 'sms',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => '??????',
                'icon'      => 'fa-user',
                'uri'       => '/users',
            ],
            [
                'parent_id' => 0,
                'order'     => 3,
                'title'     => '????????????',
                'icon'      => 'fa-joomla',
                'uri'       => '/',
            ],
            [
                'parent_id' => 10,
                'order'     => 4,
                'title'     => '????????????',
                'icon'      => 'fa-object-group',
                'uri'       => '/news',
            ],
            [
                'parent_id' => 10,
                'order'     => 5,
                'title'     => '????????????',
                'icon'      => 'fa-th',
                'uri'       => '/news-categories',
            ],
            [
                'parent_id' => 10,
                'order'     => 6,
                'title'     => '????????????',
                'icon'      => 'fa-tags',
                'uri'       => '/newstags',
            ],
            [
                'parent_id' => 0,
                'order'     => 4,
                'title'     => '????????????',
                'icon'      => 'fa-sitemap',
                'uri'       => '/portfolios',
            ],
            [
                'parent_id' => 0,
                'order'     => 5,
                'title'     => '????????????',
                'icon'      => 'fa-sitemap',
                'uri'       => '/templates',
            ],
            [
                'parent_id' => 0,
                'order'     => 6,
                'title'     => '????????????',
                'icon'      => 'fa-phone',
                'uri'       => '/contacts',
            ],
            [
                'parent_id' => 0,
                'order'     => 7,
                'title'     => '????????????',
                'icon'      => 'fa-sliders',
                'uri'       => '/sliders',
            ],
            [
                'parent_id' => 0,
                'order'     => 8,
                'title'     => '????????????',
                'icon'      => 'fa-file-o',
                'uri'       => '/pages',
            ],
            [
                'parent_id' => 0,
                'order'     => 9,
                'title'     => 'SEO??????',
                'icon'      => 'fa-euro',
                'uri'       => '/seo-items',
            ],
            [
                'parent_id' => 0,
                'order'     => 10,
                'title'     => '????????????',
                'icon'      => 'fa-columns',
                'uri'       => 'partners',
            ],
            [
                'parent_id' => 0,
                'order'     => 11,
                'title'     => 'FAQ',
                'icon'      => 'fa-book',
                'uri'       => 'faqs',
            ],
            [
                'parent_id' => 0,
                'order'     => 12,
                'title'     => '???????????????',
                'icon'      => 'fa-anchor',
                'uri'       => '/',
            ],
            [
                'parent_id' => 22,
                'order'     => 1,
                'title'     => '???????????????',
                'icon'      => 'fa-anchor',
                'uri'       => '/dealers',
            ],
            [
                'parent_id' => 22,
                'order'     => 2,
                'title'     => '????????????',
                'icon'      => 'fa-delicious',
                'uri'       => '/area',
            ],
            [
                'parent_id' => 0,
                'order'     => 13,
                'title'     => '????????????',
                'icon'      => 'fa-toggle-on',
                'uri'       => 'configx/edit',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => '????????????',
                'icon'      => 'fa-database',
                'uri'       => 'logs',
            ],
            [
                'parent_id' => 0,
                'order'     => 15,
                'title'     => 'DEMO',
                'icon'      => 'fa-android',
                'uri'       => 'demos',
            ],
        ]);

        // add role to menu.
        Menu::find(2)->roles()->save(Role::first());
    }
}
