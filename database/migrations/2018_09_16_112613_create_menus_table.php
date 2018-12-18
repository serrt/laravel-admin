<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'menus';
        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable()->comment('权限名称');
            $table->integer('pid')->nullable()->default(0)->comment('上级ID');
            $table->string('key', 100)->nullable()->comment('图标');
            $table->string('url')->nullable()->comment('链接地址/路由名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('description', 50)->nullable()->comment('描述');
        });
        DB::statement("ALTER TABLE $table_name comment '菜单'");

        $table_name1 = 'user_menus';
        Schema::create('user_menus', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('menu_id');
        });
        DB::statement("ALTER TABLE $table_name1 comment '用户拥有的菜单'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('user_menus');
    }
}
