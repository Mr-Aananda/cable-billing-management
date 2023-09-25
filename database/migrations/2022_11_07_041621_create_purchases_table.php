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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId("supplier_id")->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->string("voucher_no", 45);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('discount_type')->nullable();
            $table->decimal('total_paid', 12, 2)->default(0);
            $table->decimal('due', 12, 2)->default(0);
            $table->string('payment_type')->nullable();
            $table->foreignId('cash_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('previous_balance', 12, 2)->default(0);
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
