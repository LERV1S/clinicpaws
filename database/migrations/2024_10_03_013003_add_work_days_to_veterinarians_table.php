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
        Schema::table('veterinarians', function (Blueprint $table) {
            $table->boolean('works_on_monday')->default(true);
            $table->boolean('works_on_tuesday')->default(true);
            $table->boolean('works_on_wednesday')->default(true);
            $table->boolean('works_on_thursday')->default(true);
            $table->boolean('works_on_friday')->default(true);
            $table->boolean('works_on_saturday')->default(false);
            $table->boolean('works_on_sunday')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veterinarians', function (Blueprint $table) {
            $table->dropColumn('works_on_monday');
            $table->dropColumn('works_on_tuesday');
            $table->dropColumn('works_on_wednesday');
            $table->dropColumn('works_on_thursday');
            $table->dropColumn('works_on_friday');
            $table->dropColumn('works_on_saturday');
            $table->dropColumn('works_on_sunday');
        });
    }
};
