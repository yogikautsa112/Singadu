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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('description');
            $table->enum('type', ['KEJAHATAN', 'PEMBANGUNAN', 'SOSIAL']);
            $table->string('province');
            $table->string('regency');
            $table->string( 'subdistrict');
            $table->string('village');
            $table->json( 'voting');
            $table->integer('views')->default(0);
            $table->boolean('statement')->default(false);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
