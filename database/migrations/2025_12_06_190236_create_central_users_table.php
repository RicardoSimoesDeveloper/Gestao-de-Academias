<?php

use Database\Seeders\CentralUserSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Artisan::call('db:seed', [
        //     '--class' => CentralUserSeeder::class,
        // ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('central_users');
    }
};
