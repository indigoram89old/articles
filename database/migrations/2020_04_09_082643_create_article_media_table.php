<?php

use App\Models\ArticleMedia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();

            $table->bigInteger('article_id')->unsigned();
            
            $table->string('type')->default(ArticleMedia::TYPE_FEATURED);
            $table->string('file')->default(ArticleMedia::FILE_IMAGE);
            
            $table->string('slug');
            $table->string('link');
            
            $table->string('source')->nullable();
            $table->string('copyright')->nullable();
            $table->string('caption')->nullable();
            $table->string('credit')->nullable();
            
            $table->smallInteger('width')->unsigned()->nullable();
            $table->smallInteger('height')->unsigned()->nullable();
            
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_media');
    }
}
