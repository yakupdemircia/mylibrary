<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn');
            $table->string('title');
            $table->string('image')->nullable();
            $table->bigInteger('category_id');
            $table->bigInteger('author_id');
            $table->bigInteger('publisher_id');
            $table->string('edition')->nullable();
            $table->bigInteger('purchase_date');
            $table->decimal('cost',2)->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->default(1);
            $table->integer('in_rent')->default(0);
            $table->boolean('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('books');
    }
}
