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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['medicine_name', 'dosage', 'instructions']);
        });
    }
    
    public function down()
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('medicine_name');
            $table->string('dosage');
            $table->text('instructions')->nullable();
        });
    }
    
};
