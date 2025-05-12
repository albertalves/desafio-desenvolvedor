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
        Schema::create('file_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_history_id')->constrained('file_histories');
            $table->date('rpt_dt');
            $table->string('tckr_symb');
            $table->string('mkt_nm');
            $table->string('scty_ctgy_nm');
            $table->string('isin');
            $table->string('crpn_mm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_data');
    }
};
