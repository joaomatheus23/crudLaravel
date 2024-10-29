<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->string('nome'); 
            $table->decimal('preco', 10, 2); 
            $table->integer('quantidade'); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
