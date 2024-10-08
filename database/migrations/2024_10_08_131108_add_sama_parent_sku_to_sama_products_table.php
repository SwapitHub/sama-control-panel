<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSamaParentSkuToSamaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sama_products', function (Blueprint $table) {
            $table->string('sama_parent_sku')->nullable()->after('on_parent_sku'); // Adjust 'some_column' to where you want to place this column
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
            $table->dropColumn('sama_parent_sku');
        });
    }
}
