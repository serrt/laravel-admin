# admin-iframe
Laravel + AdminlLte + Iframe

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
8. 本地文件上传, `php artisan storage:link` 或者手动创建软连 `ln -s public/storage storage/app/public`


## Feature

### 后台权限

- 加入权限 [laravel-permission](https://github.com/spatie/laravel-permission)
- 添加管理员菜单, `php artisan db:seed --class=MenusTableSeeder`, 并将全部菜单赋予**第一个**管理员
- 根据后台路由(`admin.php`) 添加权限, `php artisan db:seed --class=PermissionsTableSeeder`, 并将全部权限赋予`administer`

## TODO

### [拖动排序](https://github.com/RubaXa/Sortable)

- 菜单的拖动排序

### [laravel-permission](https://github.com/spatie/laravel-permission)

- 权限缓存问题

### component.tree

- 无限级组件的封装, View: `admin.menus.tree`


