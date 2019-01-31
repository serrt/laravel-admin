# admin-iframe

构建后台项目

## 项目要求

- php >= 7.1
- composer
- mysql >= 5.6

## 安装

1. `composer install`
2. 复制`.env.example`文件为`.env`
3. `php artisan key:generate`
4. 修改`.env`中的`APP_URL`为虚拟主机中配置的域名, 并配置数据库连接
```
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin-iframe
DB_USERNAME=homestead
DB_PASSWORD=secret
```
5. `php artisan migrate --seed` 数据库迁移和填充
6. 数据库迁移后, 默认的后台用户`username: admin, password: 123456`, 也可以自己后台用户`php artisan generate:admin username password`
7. `bootstrap/cache` 和 `storage/` 两个目录需要配置**读写**权限
8. 本地文件上传, `php artisan storage:link` 或者手动创建软连 `ln -s /项目目录/storage/app/public public/storage`
9. 配置文件 `config('permission.debug')` 或者 `env('PERMISSION_DEBUG')`; 为 `true` 时, 不验证权限, `false` 时, 强制验证权限

## Feature

### 后台权限

- 加入权限 [laravel-permission](https://github.com/spatie/laravel-permission), 增加 **权限调试模式(不验证权限)**, 修改 `.env` 文件 `PERMISSION_DEBUG=true`
- 添加管理员菜单, `php artisan db:seed --class=MenusTableSeeder`, 并将全部菜单赋予**第一个**管理员
- 根据后台路由(`admin.php`) 添加权限, `php artisan db:seed --class=PermissionsTableSeeder`, 并将全部权限赋予`administer`

## TODO

### [laravel-permission](https://github.com/spatie/laravel-permission)

- 权限缓存问题
- 执行 `php artisan db:seed --class=PermissionsTableSeeder` 时, 清空缓存的 `Session` 菜单

### 后台菜单管理

- 根据权限查询出菜单, 同时查询出菜单的父级
- [拖动排序](https://github.com/RubaXa/Sortable)

### [file-input](http://plugins.krajee.com/file-input)

- 多文件管理

### [select2](https://select2.org)

- 异步加载数据, 在多选(`multiple`)的情况下, 重复选择相同项, 没有删除**选择的项**

## Releases

### 1.0

- 框架 [laravel/framework:5.6](https://learnku.com/docs/laravel/5.6)
- 扩展 [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- 扩展 [arcanedev/log-viewer](https://github.com/ARCANEDEV/LogViewer)
- 扩展 [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
- 扩展 [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- UI [adminlte:2.3.8](https://adminlte.io)

### 2.0(beta)

- 升级 `laravel/framework` 至 `5.7.*` 
- 添加扩展 `laravel/telescope`, [文档地址](https://laravel.com/docs/5.7/telescope)
- 删除扩展 `barryvdh/laravel-debugbar`, [文档地址](https://github.com/barryvdh/laravel-ide-helper)

