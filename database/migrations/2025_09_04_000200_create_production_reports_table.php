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
        Schema::create('production_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->nullOnDelete();;
            $table->foreignId('divisi_id')
                ->nullable()
                ->constrained('divisis')
                ->nullOnDelete();
            $table->string('so_no')->nullable();
            // $table->dateTime('tanggal');
            $table->string('customer')->nullable();
            $table->string('pdo_crd')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('pdoc_n')->nullable();
            $table->decimal('item', 10, 2)->nullable();
            $table->string('pdoc_m')->nullable();
            $table->string('actual')->nullable();
            $table->integer('shift')->nullable();
            $table->dateTime('mulai_kerja')->nullable();
            $table->dateTime('selesai_kerja')->nullable();
            $table->string('bagian')->nullable();
            $table->string('sub_bagian')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_reports');
    }
};
