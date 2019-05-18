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
- 根据后台路由(`admin.php`) 添加权限, `php artisan db:seed --class=PermissionsTableSeeder`, 并将全部权限赋予`administer`, 同时更新菜单(需要重新登陆才能看到效果)

### 阿里云 OSS

- 依赖于 [jacobcyl/ali-oss-storage](https://github.com/jacobcyl/Aliyun-oss-storage), 重写其中的一部分功能 `App\Providers\AppServiceProvider@boot`, `App\Services\AliOssAdapter`
- 配置 `.env`

```
# (可选) 修改默认的文件上传为 oss
FILESYSTEM_DRIVER=oss
# (必须) oss key
ALI_ACCESS_ID=
# (必须) oss secret
ALI_ACCESS_KEY=
# (必须) bucket 名称
ALI_BUCKET=xxx
# (必须) cdn 域名
ALI_ENDPOINT=oss-cn-xxx.aliyuncs.com
# (可选) 自定义 域名
ALI_CDN_DOMAIN=xxx.xxx.xxx
# (可选) 是否强制用 https 访问
ALI_SSL=true
```

- 用法同框架默认的 [文件系统](https://learnku.com/docs/laravel/5.7/filesystem/2281)
- 将 **远程文件** 上传到 oss

```php
// env('FILESYSTEM_DRIVER') == oss
Storage::putRemoteFile('target/path/to/file/jacob.jpg', 'http://example.com/jacob.jpg');
// env('FILESYSTEM_DRIVER') != oss
Storage::disk('oss')->putRemoteFile('target/path/to/file/jacob.jpg', 'http://example.com/jacob.jpg');
```

## TODO

### [laravel-permission](https://github.com/spatie/laravel-permission)

- 执行 `php artisan db:seed --class=PermissionsTableSeeder` 时, 清空缓存的 `Session` 菜单
- 初始化用户拥有的菜单, 根据权限判断

### 后台菜单管理

- 根据权限查询出菜单, 同时查询出菜单的父级
- [拖动排序](https://github.com/RubaXa/Sortable)

### [file-input](http://plugins.krajee.com/file-input)

- 多文件管理

### [select2](https://select2.org/)

- 分页加载时, 每页数量较少时(少于6个), 不能触发滚动加载

## Releases

### 1.0

- 框架 [laravel/framework:5.6](https://learnku.com/docs/laravel/5.7)
- 扩展 [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- 扩展 [arcanedev/log-viewer](https://github.com/ARCANEDEV/LogViewer)
- 扩展 [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
- 扩展 [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- UI [adminlte:2.3.8](https://adminlte.io)

### 2.0(beta)

- 升级 `laravel/framework` 至 `5.7.*` 
- 删除扩展 `barryvdh/laravel-debugbar`, [文档地址](https://github.com/barryvdh/laravel-debugbar)

### 2.1

- 还原扩展 `barryvdh/laravel-debugbar` (还是这个用起习惯 :smile:), [文档地址](https://github.com/barryvdh/laravel-debugbar)
- 添加权限缓存, 缓存页面的 `Title` 部分和 `breadcrumb` 部分 
- 修改权限初始化的翻译文件
- 在页面头部添加 **手动清除当前用户的菜单缓存, 权限缓存** 按钮

### 2.2

- 移除扩展 [laravel-telescope](https://laravel.com/docs/5.7/telescope)
- 修复权限的bug(分配权限后, 还是看到全部的菜单)
- 修改数据表结构 **keywords.type** => **keywords.type_id**
- 添加后台登陆页背景图(在 `views/admin/auth/login.blade.php` 可以自由更换)
