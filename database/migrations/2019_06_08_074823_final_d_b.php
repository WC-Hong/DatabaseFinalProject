<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinalDB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->string('name',10);
			$table->char('email',32);
			$table->char('password',64);
			$table->char('phone',10);
			$table->char('ID',8);
			$table->primary('ID');
			$table->timestamps();
		});

		Schema::create('manager', function (Blueprint $table) {
			$table->string('name',10);
			$table->char('email',32);
			$table->char('password',64);
			$table->char('phone',10);
			$table->char('ID',6);
			$table->primary('ID');
			$table->timestamps();
		});
		
		Schema::create('item', function (Blueprint $table) {
			$table->increments('id');
			$table->char('sID',8);
			$table->string('schedule',32);
			$table->string('nschedule',32);
			$table->string('file_path',80);
			$table->string('file_name',20);
			$table->timestamp('itemdate');
			
			$table->foreign('sID')->references('ID')->on('users');
		});

		Schema::create('file', function (Blueprint $table) {
			$table->increments('fid');
			$table->string('path')->unsigned();
            $table->string('name')->unsigned();
		});
		
		Schema::create('team', function (Blueprint $table) {
			$table->increments('teamID');
			$table->string('topic',100);
			$table->string('projectname',40);
			$table->timestamps();
		});
		
		Schema::create('sign_in', function (Blueprint $table) {
			$table->increments('sign_in_id');
			$table->char('tID',6);
			$table->char('sID',8);
			$table->integer('gID')->unsigned();
			$table->timestamps();
			
			$table->foreign('tID')->references('ID')->on('manager');
			$table->foreign('sID')->references('ID')->on('users');
			$table->foreign('gID')->references('teamID')->on('team');
		});
		
		Schema::create('ganttchart', function (Blueprint $table) {
			$table->increments('PID');
			$table->integer('gID')->unsigned();
			
			$table->foreign('gID')->references('teamID')->on('team');
		});

		Schema::create('work', function (Blueprint $table) {
			$table->increments('wid');
			$table->integer('ganttchart_id')->unsigned();
			$table->string('content', 20);
			
			$table->foreign('ganttchart_id')->references('PID')->on('ganttchart');
		});
		
		Schema::create('day', function (Blueprint $table) {
			$table->increments('dayid');
			$table->integer('work_id')->unsigned();
			$table->date('start_day');
			$table->date('end_date');
			
			$table->foreign('work_id')->references('wid')->on('work');
		});
		
		
			
	}
	
}
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    /*public function down()
    {
		Schema::drop('posts');
    }*/
