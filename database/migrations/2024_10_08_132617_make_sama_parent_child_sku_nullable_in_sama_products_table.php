<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSamaParentChildSkuNullableInSamaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sama_products', function (Blueprint $table) {
            $table->text('sama_parent')->nullable()->change();
            $table->text('sama_child_sku')->nullable()->change();
            $table->text('sama_sku')->nullable()->change();
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
            $table->text('sama_parent')->nullable(false)->change();
            $table->text('sama_child_sku')->nullable(false)->change();
            $table->text('sama_sku')->nullable(false)->change();
        });
    }
}
