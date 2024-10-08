<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToSamaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sama_products', function (Blueprint $table) {
            $table->text('description')->nullable()->after('bandweight'); // Specify the column after which it should be added
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sama_products', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
