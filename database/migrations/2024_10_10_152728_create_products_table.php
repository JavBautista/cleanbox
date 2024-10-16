<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->boolean('active')->default(1);
            $table->string('key');
            $table->string('key_alt');
            $table->string('barcode')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->string('purcahse_unit')->nullable();
            $table->string('sales_unit')->nullable();
            $table->string('factor')->nullable();
            $table->boolean('tax')->default(0);
            $table->boolean('net')->default(0);

            $table->decimal('cost',8,2)->nullable();
            $table->decimal('price_1',8,2)->nullable();
            $table->decimal('price_2',8,2)->nullable();
            $table->decimal('price_3',8,2)->nullable();
            $table->decimal('price_4',8,2)->nullable();

            $table->string('url_video')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
