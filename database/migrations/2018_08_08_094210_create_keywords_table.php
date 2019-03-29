<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeywordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keywords_type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key', 100)->nullable();
			$table->string('name', 100)->nullable();
		});
		DB::statement("ALTER TABLE `keywords_type` comment '字典类型'");

		Schema::create('keywords', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type_id')->nullable()->comment('关联kewords_type.id');
			$table->string('type_key', 100)->nullable()->comment('关联kewords_type.key');
			$table->string('key', 100)->nullable();
			$table->string('name', 100)->nullable();
			$table->integer('sort')->default(0);
		});
		DB::statement("ALTER TABLE `keywords` comment '字典类型'");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('keywords_type');
		Schema::drop('keywords');
	}

}
