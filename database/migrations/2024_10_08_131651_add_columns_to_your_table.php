<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToYourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sama_products', function (Blueprint $table) {
            $table->string('center_stone_options')->nullable()->after('bandweight');
            $table->string('matching_wedding_band')->nullable()->after('center_stone_options');
            $table->string('product')->nullable()->after('matching_wedding_band');
            $table->timestamp('created_at')->nullable()->after('product');
            $table->timestamp('updated_at')->nullable()->after('created_at');
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
            $table->dropColumn(['center_stone_options', 'matching_wedding_band', 'product', 'created_at', 'updated_at']);
        });
    }
}
