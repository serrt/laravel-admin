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
		Schema::create('keywords', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type')->nullable()->comment('关联kewords_type.id');
			$table->string('type_key', 100)->nullable()->comment('关联kewords_type.key');
			$table->string('key', 100)->nullable();
			$table->string('name', 100)->nullable();
			$table->integer('sort')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('keywords');
	}

}
