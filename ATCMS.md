# ATCMS 内容管理系统 V1.1

注意：
该md文件应仅存在于此仓库（atcms），基于该仓库创建项目时，应删除此文件。
项目说明统一使用 `README.MD`。

## 介绍

- Laravel 6.0 框架
- 使用 [encore/laravel-admin](https://laravel-admin.org/docs/zh/) 开发后台
- 可根据情况安装插件 [laravel-admin-extensions](https://github.com/laravel-admin-extensions)
- 支持导入导出 [Laravel-Excel](https://github.com/Maatwebsite/Laravel-Excel)
- Token [jwt](https://learnku.com/articles/10885/full-use-of-jwt)

## 新增项目

- 复制项目文件，排除 `.git`, `vendor`, `node_modules`, `ATCMS.md`, `CHANGELOG.md`
- 修改 `.env.example` 文件

## 新增模块

**替换`Test`为模块名，统一单数（数据库为复数）**

- `php artisan make:model Models/Test -m` 创建模型及迁移文件
- `php artisan admin:make TestController --model=App\Models\Test` 创建控制器
- 增加路由：`app\Admin\Routes.php`
- 添加菜单：修改 `database\seeds\AdminTablesSeeder.php`，或 后台->系统管理->菜单管理

## 手动部署流程

[http://www.anttoweb.com/kb/laravel-start/](http://www.anttoweb.com/kb/laravel-start/)

## 注意事项

### Laravel-admin 本地已修改文件

resources\views\admin\partials\footer.blade.php
resources\views\admin\partials\header.blade.php
resources\views\admin\partials\menu.blade.php
resources\views\admin\login.blade.php (背景路由，引入 skin-custom.css 文件)
resources\views\admin\form\ueditor.blade.php
resources\views\admin\tree\branch.blade.php

### 版本更新

更新目录 `resources/views/admin` 下的截图资源

```sh
// 强制发布静态资源文件
php artisan vendor:publish --tag=laravel-admin-assets --force

// 强制发布语言包文件
php artisan vendor:publish --tag=laravel-admin-lang --force

// 清理视图缓存
php artisan view:clear
```
