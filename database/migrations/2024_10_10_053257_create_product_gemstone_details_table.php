<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGemstoneDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_gemstone_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->text('GemstoneShape1')->nullable();
            $table->text('NoOfGemstones1')->nullable();
            $table->text('NoOfGemstones1_Min')->nullable();
            $table->text('NoOfGemstones1_Max')->nullable();
            $table->text('GemstoneCaratWeight1')->nullable();
            $table->text('GemstoneCaratWeight1_Min')->nullable();
            $table->text('GemstoneCaratWeight1_Max')->nullable();
            $table->text('GemstoneShape2')->nullable();
            $table->text('NoOfGemstones2')->nullable();
            $table->text('NoOfGemstones2_Min')->nullable();
            $table->text('NoOfGemstones2_Max')->nullable();
            $table->text('GemstoneCaratWeight2')->nullable();
            $table->text('GemstoneCaratWeight2_Min')->nullable();
            $table->text('GemstoneCaratWeight2_Max')->nullable();
            $table->text('GemstoneShape3')->nullable();
            $table->text('NoOfGemstones3')->nullable();
            $table->text('NoOfGemstones3_Min')->nullable();
            $table->text('NoOfGemstones3_Max')->nullable();
            $table->text('GemstoneCaratWeight3')->nullable();
            $table->text('GemstoneCaratWeight3_Min')->nullable();
            $table->text('GemstoneCaratWeight3_Max')->nullable();
            $table->text('GemstoneShape4')->nullable();
            $table->text('NoOfGemstones4')->nullable();
            $table->text('NoOfGemstones4_Min')->nullable();
            $table->text('NoOfGemstones4_Max')->nullable();
            $table->text('GemstoneCaratWeight4')->nullable();
            $table->text('GemstoneCaratWeight4_Min')->nullable();
            $table->text('GemstoneCaratWeight4_Max')->nullable();
            $table->text('GemstoneShape5')->nullable();
            $table->text('NoOfGemstones5')->nullable();
            $table->text('NoOfGemstones5_Min')->nullable();
            $table->text('NoOfGemstones5_Max')->nullable();
            $table->text('GemstoneCaratWeight5')->nullable();
            $table->text('GemstoneCaratWeight5_Min')->nullable();
            $table->text('GemstoneCaratWeight5_Max')->nullable();
            $table->text('GemstoneShape6')->nullable();
            $table->text('NoOfGemstones6')->nullable();
            $table->text('NoOfGemstones6_Min')->nullable();
            $table->text('NoOfGemstones6_Max')->nullable();
            $table->text('GemstoneCaratWeight6')->nullable();
            $table->text('GemstoneCaratWeight6_Min')->nullable();
            $table->text('GemstoneCaratWeight6_Max')->nullable();
            $table->text('GemstoneShape7')->nullable();
            $table->text('NoOfGemstones7')->nullable();
            $table->text('NoOfGemstones7_Min')->nullable();
            $table->text('NoOfGemstones7_Max')->nullable();
            $table->text('GemstoneCaratWeight7')->nullable();
            $table->text('GemstoneCaratWeight7_Min')->nullable();
            $table->text('GemstoneCaratWeight7_Max')->nullable();
            $table->text('GemstoneShape8')->nullable();
            $table->text('NoOfGemstones8')->nullable();
            $table->text('NoOfGemstones8_Min')->nullable();
            $table->text('NoOfGemstones8_Max')->nullable();
            $table->text('GemstoneCaratWeight8')->nullable();
            $table->text('GemstoneCaratWeight8_Min')->nullable();
            $table->text('GemstoneCaratWeight8_Max')->nullable();
            $table->text('GemstoneShape9')->nullable();
            $table->text('NoOfGemstones9')->nullable();
            $table->text('NoOfGemstones9_Min')->nullable();
            $table->text('NoOfGemstones9_Max')->nullable();
            $table->text('GemstoneCaratWeight9')->nullable();
            $table->text('GemstoneCaratWeight9_Min')->nullable();
            $table->text('GemstoneCaratWeight9_Max')->nullable();
            $table->text('GemstoneShape10')->nullable();
            $table->text('NoOfGemstones10')->nullable();
            $table->text('NoOfGemstones10_Min')->nullable();
            $table->text('NoOfGemstones10_Max')->nullable();
            $table->text('GemstoneCaratWeight10')->nullable();
            $table->text('GemstoneCaratWeight10_Min')->nullable();
            $table->text('GemstoneCaratWeight10_Max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_gemstone_details');
    }
}
