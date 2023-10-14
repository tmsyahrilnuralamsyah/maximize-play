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
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('no_id')->unique();
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('upline');
            $table->string('downline1')->nullable();
            $table->string('downline2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
