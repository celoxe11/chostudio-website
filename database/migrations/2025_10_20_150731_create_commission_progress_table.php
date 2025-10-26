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
            $table->unsignedBigInteger('commission_id'); // FK ke commisions.commission_id tanpa constraint
            $table->string('image_link');
            $table->enum('stage', ['sketch', 'coloring', 'final', 'revision'])->default('sketch');
            $table->text('description')->nullable();
            $table->string('status_from', 50)->nullable();
            $table->string('status_to', 50)->nullable();
            $table->timestamps();
            $table->softDeletes(); // deleted_at untuk soft delete
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
