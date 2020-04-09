<?php

use App\Models\ArticleMedia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleMediaPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_media_pivot', function (Blueprint $table) {
            
            $table->bigInteger('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles');

            $table->bigInteger('media_id')->unsigned();
            $table->foreign('media_id')->references('id')->on('article_media');
            
            $table->string('type')->default(ArticleMedia::TYPE_FEATURED);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_media_pivot');
    }
}
