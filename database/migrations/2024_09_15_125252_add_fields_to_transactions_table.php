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
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('name');
            $table->tinyText('currency');
            $table->decimal('amount');
            $table->dateTime('transaction_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('transactions', [
            'name',
            'currency',
            'amount',
            'transaction_at'
        ]);
    }
};
