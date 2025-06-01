<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class CreateWatchlistsTable extends Migration
   {
       public function up()
       {
           Schema::create('watchlists', function (Blueprint $table) {
               $table->id();
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->unsignedBigInteger('movie_id');
               $table->string('movie_title');
               $table->string('poster_path')->nullable();
               $table->timestamps();
               
               $table->unique(['user_id', 'movie_id']);
           });
       }

       public function down()
       {
           Schema::dropIfExists('watchlists');
       }
   }