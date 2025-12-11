<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Students jadvali
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // id int primary key autoincrement
            $table->unsignedBigInteger('student_id')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('faculty')->nullable();
            $table->string('group')->nullable();
            $table->string('phone')->nullable();
            $table->string('coach')->nullable();
            $table->string('father')->nullable();
            $table->string('mather')->nullable();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->string('address')->nullable();
            $table->string('map_home')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mather_phone')->nullable();
            $table->timestamps();
        });

        // Dormitory jadvali
        Schema::create('dormitory', function (Blueprint $table) {
            $table->id(); // in int primary key autoincrement
            $table->unsignedBigInteger('student_id')->unsigned();
            $table->string('dormitory');
            $table->integer('room');
            $table->float('privileged')->default(0); // %
            $table->float('amount')->default(0);
            $table->timestamps();

            $table->foreign('student_id')
                ->references('student_id')
                ->on('students')
                ->onDelete('cascade');
        });

        // Rent jadvali
        Schema::create('rents', function (Blueprint $table) {
            $table->id(); // in int primary key autoincrement
            $table->unsignedBigInteger('student_id')->unsigned();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->string('address')->nullable();
            $table->string('map_rent')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('type')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('category')->nullable();
            $table->float('contract')->default(0);
            $table->float('amount')->default(0);
            $table->timestamps();

            $table->foreign('student_id')
                ->references('student_id')
                ->on('students')
                ->onDelete('cascade');
        });

        Schema::create('student_passwrod', function (Blueprint $table) {
            $table->id(); // in int primary key autoincrement
            $table->unsignedBigInteger('student_id')->unsigned();
            $table->string('password');
            $table->timestamps();
        });
        
        Schema::create('forgets', function (Blueprint $table) {
            $table->id(); // in int primary key autoincrement
            $table->unsignedBigInteger('student_id')->unsigned();
            $table->string('messeng');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
        Schema::dropIfExists('dormitory');
        Schema::dropIfExists('students');
    }
};
