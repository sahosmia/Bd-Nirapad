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
        Schema::create('mobile_recharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->constrained('operators')->onDelete('cascade');
            $table->string('number');
            $table->string('number_type');
            $table->decimal('amount', 10, 2);
            $table->decimal('updated_credits', 10, 2);
            $table->decimal('recivers_user_previous_credits', 10, 2);
            $table->tinyInteger('status')->default(3);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->nullable()->constrained('plan_types')->onDelete('set null');
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
        Schema::dropIfExists('mobile_recharges');
    }
};
