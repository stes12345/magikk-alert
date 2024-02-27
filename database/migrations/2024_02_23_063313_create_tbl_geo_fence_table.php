<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_geo_fence', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->integer('created_by');
            $table->integer('company_id')->nullable();
            $table->geometry('geom')->nullable();
            $table->decimal('geom_area', 10, 2)->nullable();
            $table->enum('status', [0, 1])->default(1)->comment('0->Inactive,1->Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_geo_fence');
    }
};
