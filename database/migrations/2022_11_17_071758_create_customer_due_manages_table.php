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
        Schema::create('customer_due_manages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->date('date');
            $table->decimal('amount', 12, 2)->default(0.00)->comment('positive amount ii received & negetive amount is paid');
            $table->string('payment_type')->nullable();
            $table->foreignId('cash_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('adjustment', 12, 2)->default(0.00);
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
        Schema::dropIfExists('customer_due_manages');
    }
};
