<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotBlogTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_tag', function(Blueprint $table) {

            $table->increments('id');

            $table->integer('blog_id')->unsigned()->index();
			$table->integer('tag_id')->unsigned()->index();

			$table->foreign('blog_id')->references('id')->on('blog')->onDelete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_tag');
	}

}
