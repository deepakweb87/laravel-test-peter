<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('message');
            $table->string('street');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->string('images')->nullable();
            $table->string('files')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
