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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid();
            $table->foreignUuid('user_id')->constrained('users', 'uuid');
            $table->foreignUuid('product_id')->constrained('products', 'uuid');
            $table->integer('price')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('admin_fee')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
