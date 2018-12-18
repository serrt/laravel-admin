<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('路由name');
            $table->string('guard_name');
            $table->string('display_name')->nullable()->comment('名称');
            $table->integer('pid')->default(0)->comment('父级id');
//            $table->string('icon', 100)->nullable()->comment('图标');
//            $table->string('description', 100)->nullable()->comment('描述');
            $table->integer('menu_id')->nullable()->default(0)->comment('关联菜单(menu.id)');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".$tableNames['permissions']." comment '权限菜单'");

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->string('display_name')->nullable()->comment('名称');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE ".$tableNames['roles']." comment '角色'");

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type', ]);

//            $table->foreign('permission_id')
//                ->references('id')
//                ->on($tableNames['permissions'])
//                ->onDelete('cascade');

//            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_permission_model_type_primary');
        });

        DB::statement("ALTER TABLE ".$tableNames['model_has_permissions']." comment '用户拥有的权限'");

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type', ]);

//            $table->foreign('role_id')
//                ->references('id')
//                ->on($tableNames['roles'])
//                ->onDelete('cascade');
//
//            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],'model_has_roles_role_model_type_primary');
        });

        DB::statement("ALTER TABLE ".$tableNames['model_has_roles']." comment '用户拥有的角色'");

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

//            $table->foreign('permission_id')
//                ->references('id')
//                ->on($tableNames['permissions'])
//                ->onDelete('cascade');

//            $table->foreign('role_id')
//                ->references('id')
//                ->on($tableNames['roles'])
//                ->onDelete('cascade');

//            $table->primary(['permission_id', 'role_id']);
        });

        DB::statement("ALTER TABLE ".$tableNames['role_has_permissions']." comment '角色拥有的角色'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
