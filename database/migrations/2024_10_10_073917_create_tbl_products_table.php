<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 50)->nullable();
            $table->bigInteger('menu')->nullable();
            $table->text('category');
            $table->text('sub_category');
            $table->integer('category_id')->nullable();
            $table->text('subcategory_ids');
            $table->bigInteger('entity_id')->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('internal_sku', 50)->nullable();
            $table->string('parent_sku', 50)->default('NULL');
            $table->string('name', 50)->nullable();
            $table->string('product_browse_pg_name', 50)->nullable();
            $table->string('slug', 50)->nullable();
            $table->longText('description');
            $table->longText('lab_grown_diamond_price');
            $table->longText('diamond_quality_2_price');
            $table->longText('finalprice');
            $table->longText('goldprice');
            $table->longText('silverprice');
            $table->text('platinumprice');
            $table->text('palladiumprice');
            $table->text('fractioncenter');
            $table->text('fractionsemimount');
            $table->longText('fractioncomplete');
            $table->text('metalType');
            $table->integer('metalType_id')->nullable();
            $table->text('metalColor');
            $table->integer('metalColor_id')->nullable();
            $table->text('finishLevel');
            $table->text('diamondQuality');
            $table->text('FingerSize');
            $table->text('CenterShape');
            $table->text('SideDiamondNumber');
            $table->text('metalWeight');
            $table->text('shippingDay');
            $table->text('WeightUnit');
            $table->text('TotalDiamondWeight');
            $table->text('categoryvalue');
            $table->text('default_image_url');
            $table->text('default_image_alt');
            $table->longText('images');
            $table->longText('videos');
            $table->float('white_gold_price')->nullable();
            $table->float('yellow_gold_price')->nullable();
            $table->float('rose_gold_price')->nullable();
            $table->float('platinum_price')->nullable();
            $table->text('similar_products');
            $table->text('center_stone_options');
            $table->text('center_stones');
            $table->text('matching_wedding_band');
            $table->string('is_newest', 50)->nullable();
            $table->string('is_bestseller', 50)->nullable();
            $table->enum('status', ['true', 'false']);
            $table->text('meta_title');
            $table->text('meta_keyword');
            $table->text('meta_description');
            $table->json('api_response')->nullable();
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
        Schema::dropIfExists('tbl_products');
    }
}
