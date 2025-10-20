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
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id('adoption_id'); // PK
            $table->foreignId('gallery_id')->constrained('gallery', 'gallery_id')->onDelete('restrict'); // FK ke gallery.gallery_id
            $table->string('email');
            $table->enum('order_status', ['placed', 'shipped', 'delivered', 'canceled'])->default('placed');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};
