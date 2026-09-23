<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('headline')->nullable();
            $table->string('gender', 30)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->json('interests')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('location')->nullable();
            $table->string('github_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
