<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MainRefDepartmentArchive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SYSTEM_ARCHIVE', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->unsignedInteger('ProvinceId');
            $table->unsignedInteger('DepartmentId');
            $table->string('Archive', 150);
            $table->string('Abbr', 50);
            $table->integer('CreatedBy');
            $table->integer('ModifiedBy');
            $table->timestamp('CreatedDate');
            $table->timestamp('ModifiedDate');
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
        Schema::dropIfExists('SYSTEM_ARCHIVE');
    }
}
