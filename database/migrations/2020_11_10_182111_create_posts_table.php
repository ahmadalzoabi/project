<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->dateTime('date_written',0);
            $table->string('featured_image')
                        ->nullable();
            $table->integer('votes_up')
                        ->nullable();  
            $table->integer('votes_down')
                         ->nullable();
            $table->text( 'voters_up' )->nullable()->default(null);
            $table->text( 'voters_down' )->nullable()->default(null);             
            // Relationships
            $table->integer('user_id'); 
            $table->integer('category_id');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
