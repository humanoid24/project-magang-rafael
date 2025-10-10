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
            $table->dateTime('pdo_due_date')->nullable();
            $table->string('so_no')->nullable();
            // $table->dateTime('tanggal');
            $table->string('customer')->nullable();
            $table->string('pdo_crd')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('qty')->nullable();
            $table->string('tebal')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->decimal('item_weight', 10, 2)->nullable();
            $table->integer('jumlah_stroke')->nullable();
            $table->integer('actual_hasil')->nullable();
            $table->string('weight_total')->nullable();
            $table->dateTime('start_tidak')->nullable();
            $table->dateTime('selesai_tidak')->nullable();
            $table->dateTime('total_tidak')->nullable();
            $table->dateTime('mulai_kerja')->nullable();
            $table->dateTime('selesai_kerja')->nullable();
            $table->decimal('hasil_jam_kerja', 8, 2)->nullable();            
            $table->decimal('performa', 10, 2)->nullable();
            $table->string('group')->nullable();
            $table->integer('shift')->nullable();
            $table->string('bagian')->nullable();
            $table->string('sub_bagian')->nullable();
            $table->text('catatan')->nullable();
            $table->string('sheet_date')->nullable();
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
