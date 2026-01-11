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
        Schema::create('bank_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->foreignId('bank_district_id')->constrained('bank_districts')->onDelete('cascade');
            $table->foreignId('bank_branch_id')->constrained('bank_branch_names')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->decimal('updated_credits', 10, 2);
            $table->decimal('recivers_user_previous_credits', 10, 2);
            $table->tinyInteger('status')->default(3);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('bank_requests');
    }
};
