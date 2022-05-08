<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            
            $table->string('city')->nullable();
            $table->string('source')->nullable();
            $table->string('category')->nullable();

            // sahipsiz customerları model helper ile bulurum

            $table->enum('status', ['queued', 'positive', 'negative', 'busy'])->default('queued');
            $table->smallInteger('score')->default(0);

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
        Schema::dropIfExists('customers');
    }
};
