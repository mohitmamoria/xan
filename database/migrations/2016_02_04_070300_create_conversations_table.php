<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trigger_tweet_id');
            $table->string('sniper_user_id');
            $table->string('sniper_user_screen_name');
            $table->integer('sniper_user_utc_offset');
            $table->string('target_user_id');
            $table->string('target_user_screen_name');
            $table->tinyInteger('story_id');
            $table->tinyInteger('last_chapter_sequence')->default(0); // by default set 0; incremented when sent first chapter
            $table->string('closing_tweet_id')->nullable();
            $table->nullableTimestamps();
            $table->timestamp('gave_up_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('first_chapter_at')->nullable();
            $table->timestamp('last_chapter_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conversations');
    }
}
