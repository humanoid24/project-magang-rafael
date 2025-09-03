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
        Schema::create('ppics', function (Blueprint $table) {
            $table->id();
            $table->string('so_no');
            $table->string('customer');
            $table->string('pdo_crd');
            $table->string('item_name');
            $table->string('pdoc_n');
            $table->string('item');
            $table->string('pdoc_m');
            $table->string('actual');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppics');
    }
};
