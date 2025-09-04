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
            $table->foreignId('divisi_id')
                  ->nullable()
                  ->constrained('divisis')
                  ->nullOnDelete();
            $table->string('so_no');
            // $table->dateTime('tanggal');
            $table->string('customer');
            $table->string('pdo_crd');
            $table->string('item_name');
            $table->string('pdoc_n');
            $table->string('item');
            $table->string('pdoc_m');
            $table->string('actual');
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
