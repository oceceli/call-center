<?php

use App\Enum\CallStatus;
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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name');
            $table->string('surname');
            $table->string('phone');

            $table->boolean('is_active');

            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('source')->nullable();
            $table->string('category')->nullable();

            $table->enum('status', ['QUEUED', 'POSITIVE', 'UNANSWERED', 'BUSY'])->nullable()->default('QUEUED');
            // $table->enum('status', CallStatus::cases())->nullable()->default(CallStatus::QUEUED);
            $table->smallInteger('score')->nullable()->default(0);
            $table->string('note')->nullable();
            
            $table->timestamps();
            
            // sahipsiz customerları model helper ile bulurum
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
