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
            $table->string('permission_name')->nullable()->comment('权限关联 permissions.name');
            $table->string('name', 100)->nullable()->comment('菜单名称');
            $table->integer('pid')->nullable()->default(0)->comment('上级ID');
            $table->string('key', 100)->nullable()->comment('图标');
            $table->string('url')->nullable()->comment('链接地址/路由名称');
            $table->integer('sort')->nullable()->comment('排序');
            $table->string('description', 50)->nullable()->comment('描述');
        });
        DB::statement("ALTER TABLE $table_name comment '菜单'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
