<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('GemstoneWeight8_Max')->nullable()->after('GemstoneWeight8_Min');
            $table->text('NoOfGemstones9_Min')->nullable()->after('GemstoneWeight8_Max');
            $table->text('NoOfGemstones9_Max')->nullable()->after('NoOfGemstones9_Min');
            $table->text('GemstoneWeight9_Min')->nullable()->after('NoOfGemstones9_Max');
            $table->text('GemstoneWeight9_Max')->nullable()->after('GemstoneWeight9_Min');
            $table->text('NoOfGemstones10_Min')->nullable()->after('GemstoneWeight9_Max');
            $table->text('NoOfGemstones10_Max')->nullable()->after('NoOfGemstones10_Min');
            $table->text('GemstoneWeight10_Min')->nullable()->after('NoOfGemstones10_Max');
            $table->text('GemstoneWeight10_Max')->nullable()->after('GemstoneWeight10_Min');
            $table->text('GemstoneWeight1')->nullable()->after('GemstoneWeight10_Max');
            $table->text('bandwidth')->nullable()->after('GemstoneWeight1');
            $table->text('bandweight')->nullable()->after('bandwidth');
            $table->text('GemstoneWeight2')->nullable()->after('bandweight');
            $table->text('GemstoneWeight3')->nullable()->after('GemstoneWeight2');
            $table->text('GemstoneWeight4')->nullable()->after('GemstoneWeight3');
            $table->text('GemstoneWeight5')->nullable()->after('GemstoneWeight4');
            $table->text('GemstoneWeight6')->nullable()->after('GemstoneWeight5');
            $table->text('GemstoneWeight7')->nullable()->after('GemstoneWeight6');
            $table->text('GemstoneWeight8')->nullable()->after('GemstoneWeight7');
            $table->text('GemstoneWeight9')->nullable()->after('GemstoneWeight8');
            $table->text('GemstoneWeight10')->nullable()->after('GemstoneWeight9');
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
                'GemstoneWeight1',
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
                'GemstoneWeight10'
            ]);
        });
    }

}
