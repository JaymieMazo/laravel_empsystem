<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
      Schema::create('employees', function(Blueprint $table){
            $table->string('employee_code' , 5);
            $table->string('employee_name', 30);
            $table->integer('gender');
            $table->integer('age');
            $table->string('contract_status' ,  20 );
            $table->string('civilstatus', 20);
            $table->dateTime('birthday');
            $table->string('religion' , 30);
            $table->string('nationality', 30);
            $table->string('children' , 30);
            $table->dateTime('hired_date');
            $table->dateTime('retired_date');
            $table->string('company_code', 5);
            $table->string('department_code', 5);
            $table->string('section_code', 5);
            $table->timestamps();
            $table->softDeletes();
            $table->string('updated_by', 5);
            $table->primary('employee_code');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('employees');
    }
}
