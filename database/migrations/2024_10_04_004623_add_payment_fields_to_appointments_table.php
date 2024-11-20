<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('is_payment_required')->default(false); // Indicar si el pago es requerido
            $table->string('payment_status')->nullable();  // Estado del pago (ej: pendiente, completado)
            $table->string('payment_method')->nullable();  // Método de pago (ej: tarjeta, PayPal)
            $table->decimal('payment_amount', 8, 2)->nullable();  // Cantidad a pagar
            $table->string('payment_reference')->nullable();  // Referencia de transacción
        });
    }
    
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('is_payment_required');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_amount');
            $table->dropColumn('payment_reference');
        });
    }
    
};
