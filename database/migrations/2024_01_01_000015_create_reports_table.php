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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->foreignId('recievers_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('proof')->nullable();
            $table->foreignId('bank_request_id')->nullable()->constrained('bank_requests')->onDelete('set null');
            $table->foreignId('form')->constrained('forms')->onDelete('cascade');
            $table->decimal('updated_credits', 10, 2);
            $table->decimal('recievers_user_previous_credits', 10, 2);
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->foreignId('operator_id')->nullable()->constrained('operators')->onDelete('set null');
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('set null');
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
        Schema::dropIfExists('reports');
    }
};
