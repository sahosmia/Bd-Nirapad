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
        Schema::create('mobile_banking_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('number');
            $table->string('type');
            $table->decimal('amount', 10, 2);
            $table->decimal('updated_credits', 10, 2);
            $table->decimal('recivers_user_previous_credits', 10, 2);
            $table->tinyInteger('status')->default(3);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('users')->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->string('trxid')->nullable();
            $table->string('digits')->nullable();
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
        Schema::dropIfExists('mobile_banking_request');
    }
};
