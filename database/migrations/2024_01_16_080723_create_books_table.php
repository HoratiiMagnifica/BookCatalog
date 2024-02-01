<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150)->nullable(false);
            $table->integer('publication_year')->nullable(false);
            $table->string('description', 2000)->nullable(false);
            $table->string('cover_image', 500)->nullable();
            $table->unsignedBigInteger('author_id')->nullable(false);
            $table->unsignedBigInteger('section_id')->nullable(false);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('section_id')->references('id')->on('sections');
            // остальные поля по необходимости

        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}

