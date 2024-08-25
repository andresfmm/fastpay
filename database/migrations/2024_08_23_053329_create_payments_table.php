<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('customer_name');
            $table->string('cpf');
            $table->text('description')->nullable();
            $table->float('value');
            $table->enum('status', ['pending', 'paid', 'defeated', 'failed']);
            $table->string('payment_method', 50);
            $table->dateTime('payment_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
