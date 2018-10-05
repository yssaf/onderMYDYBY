 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('movie_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('sort_name')->nullable();
            $table->string('imdb_id')->nullable()->default(NULL);
            $table->integer('released');
            $table->integer('rating');
            $table->integer('running_time');
            $table->string('image');
            $table->integer('certificate_id')->unsigned();
            $table->foreign('certificate_id')->references('certificate_id')->on('certificates');
            $table->integer('format_id')->unsigned();
            $table->foreign('format_id')->references('format_id')->on('formats');
            $table->integer('studio_id')->unsigned();
            $table->foreign('studio_id')->references('studio_id')->on('studios');
            $table->boolean('duplicate');
            $table->text('bio');
            $table->timestamp('purchased')->default('2015-01-01 08:00:00');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
