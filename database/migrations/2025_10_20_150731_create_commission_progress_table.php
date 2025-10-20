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
        Schema::create('commission_progress', function (Blueprint $table) {
            $table->id('com_progress_id'); // PK
            $table->foreignId('commission_id')->constrained('commisions', 'commission_id')->onDelete('cascade'); // FK ke commisions.commission_id
            $table->string('image_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_progress');
    }
};
