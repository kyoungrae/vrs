<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MainUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_user', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->unsignedInteger('ProvinceId')->nullable();
            $table->unsignedInteger('UserDepartmentId')->nullable();
            $table->unsignedInteger('UserPositionId');
            $table->unsignedInteger('RefDepartmentArchiveId')->nullable();
            $table->string('UserName', 50);
            $table->string('FirstName', 100);
            $table->string('LastName', 100);
            $table->string('Email', 100)->nullable();
            $table->string('Phone', 10)->nullable();
            $table->string('Password')->nullable();
            $table->string('PasswordAnother')->nullable();
            $table->integer('IsActive')->default(0);
            $table->integer('CreatedBy');
            $table->integer('ModifiedBy');
            $table->timestamp('CreatedDate');
            $table->timestamp('ModifiedDate');
            $table->softDeletes();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_user');
    }
}
