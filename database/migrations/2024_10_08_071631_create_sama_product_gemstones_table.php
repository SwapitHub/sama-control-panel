<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamaProductGemstonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sama_product_gemstones', function (Blueprint $table) {
            $table->increments('id'); // This will create an auto-incrementing ID column
            $table->integer('product_id')->unsigned(); // Use unsigned for foreign keys
            $table->text('GemstoneShape1')->nullable();
            $table->text('NoOfGemstones1')->nullable();
            $table->text('NoOfGemstones1_Min')->nullable();
            $table->text('NoOfGemstones1_Max')->nullable();
            $table->text('GemstoneLotCode1')->nullable();
            $table->text('GemstoneWeight1')->nullable();
            $table->text('GemstoneWeight1_Min')->nullable();
            $table->text('GemstoneWeight1_Max')->nullable();
            $table->text('GemstoneShape2')->nullable();
            $table->text('NoOfGemstones2')->nullable();
            $table->text('NoOfGemstones2_Min')->nullable();
            $table->text('NoOfGemstones2_Max')->nullable();
            $table->text('GemstoneLotCode2')->nullable();
            $table->text('GemstoneWeight2')->nullable();
            $table->text('GemstoneWeight2_Min')->nullable();
            $table->text('GemstoneWeight2_Max')->nullable();
            $table->text('GemstoneShape3')->nullable();
            $table->text('NoOfGemstones3')->nullable();
            $table->text('NoOfGemstones3_Min')->nullable();
            $table->text('NoOfGemstones3_Max')->nullable();
            $table->text('GemstoneLotCode3')->nullable();
            $table->text('GemstoneWeight3')->nullable();
            $table->text('GemstoneWeight3_Min')->nullable();
            $table->text('GemstoneWeight3_Max')->nullable();
            $table->text('GemstoneShape4')->nullable();
            $table->text('NoOfGemstones4')->nullable();
            $table->text('NoOfGemstones4_Min')->nullable();
            $table->text('NoOfGemstones4_Max')->nullable();
            $table->text('GemstoneLotCode4')->nullable();
            $table->text('GemstoneWeight4')->nullable();
            $table->text('GemstoneWeight4_Min')->nullable();
            $table->text('GemstoneWeight4_Max')->nullable();
            $table->text('GemstoneShape5')->nullable();
            $table->text('NoOfGemstones5')->nullable();
            $table->text('NoOfGemstones5_Min')->nullable();
            $table->text('NoOfGemstones5_Max')->nullable();
            $table->text('GemstoneLotCode5')->nullable();
            $table->text('GemstoneWeight5')->nullable();
            $table->text('GemstoneWeight5_Min')->nullable();
            $table->text('GemstoneWeight5_Max')->nullable();
            $table->text('GemstoneShape6')->nullable();
            $table->text('NoOfGemstones6')->nullable();
            $table->text('NoOfGemstones6_Min')->nullable();
            $table->text('NoOfGemstones6_Max')->nullable();
            $table->text('GemstoneLotCode6')->nullable();
            $table->text('GemstoneWeight6')->nullable();
            $table->text('GemstoneWeight6_Min')->nullable();
            $table->text('GemstoneWeight6_Max')->nullable();
            $table->text('GemstoneShape7')->nullable();
            $table->text('NoOfGemstones7')->nullable();
            $table->text('NoOfGemstones7_Min')->nullable();
            $table->text('NoOfGemstones7_Max')->nullable();
            $table->text('GemstoneLotCode7')->nullable();
            $table->text('GemstoneWeight7')->nullable();
            $table->text('GemstoneWeight7_Min')->nullable();
            $table->text('GemstoneWeight7_Max')->nullable();
            $table->text('GemstoneShape8')->nullable();
            $table->text('NoOfGemstones8')->nullable();
            $table->text('NoOfGemstones8_Min')->nullable();
            $table->text('NoOfGemstones8_Max')->nullable();
            $table->text('GemstoneLotCode8')->nullable();
            $table->text('GemstoneWeight8')->nullable();
            $table->text('GemstoneWeight8_Min')->nullable();
            $table->text('GemstoneWeight8_Max')->nullable();
            $table->text('GemstoneShape9')->nullable();
            $table->text('NoOfGemstones9')->nullable();
            $table->text('NoOfGemstones9_Min')->nullable();
            $table->text('NoOfGemstones9_Max')->nullable();
            $table->text('GemstoneLotCode9')->nullable();
            $table->text('GemstoneWeight9_Min')->nullable();
            $table->text('GemstoneWeight9_Max')->nullable();
            $table->text('GemstoneShape10')->nullable();
            $table->text('NoOfGemstones10')->nullable();
            $table->text('NoOfGemstones10_Min')->nullable();
            $table->text('NoOfGemstones10_Max')->nullable();
            $table->text('GemstoneLotCode10')->nullable();
            $table->text('GemstoneWeight10')->nullable();
            $table->text('GemstoneWeight10_Min')->nullable();
            $table->text('GemstoneWeight10_Max')->nullable();
            $table->timestamps(); // This will create created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sama_product_gemstones');
    }
}
