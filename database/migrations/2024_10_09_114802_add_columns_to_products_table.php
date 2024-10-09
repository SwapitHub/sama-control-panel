<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('GemstoneWeight8_Max')->nullable();
            $table->text('NoOfGemstones9_Min')->nullable();
            $table->text('NoOfGemstones9_Max')->nullable();
            $table->text('GemstoneWeight9_Min')->nullable();
            $table->text('GemstoneWeight9_Max')->nullable();
            $table->integer('NoOfGemstones10_Min')->nullable();
            $table->integer('NoOfGemstones10_Max')->nullable();
            $table->integer('GemstoneWeight10_Min')->nullable();
            $table->text('GemstoneWeight10_Max')->nullable();
            $table->text('bandwidth')->nullable();
            $table->text('bandweight')->nullable();
            $table->text('GemstoneWeight2')->nullable();
            $table->text('GemstoneWeight3')->nullable();
            $table->text('GemstoneWeight4')->nullable();
            $table->text('GemstoneWeight5')->nullable();
            $table->text('GemstoneWeight6')->nullable();
            $table->text('GemstoneWeight7')->nullable();
            $table->text('GemstoneWeight8')->nullable();
            $table->text('GemstoneWeight9')->nullable();
            $table->text('GemstoneWeight10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'GemstoneWeight8_Max',
                'NoOfGemstones9_Min',
                'NoOfGemstones9_Max',
                'GemstoneWeight9_Min',
                'GemstoneWeight9_Max',
                'NoOfGemstones10_Min',
                'NoOfGemstones10_Max',
                'GemstoneWeight10_Min',
                'GemstoneWeight10_Max',
                'bandwidth',
                'bandweight',
                'GemstoneWeight2',
                'GemstoneWeight3',
                'GemstoneWeight4',
                'GemstoneWeight5',
                'GemstoneWeight6',
                'GemstoneWeight7',
                'GemstoneWeight8',
                'GemstoneWeight9',
                'GemstoneWeight10',
            ]);
        });
    }
}
