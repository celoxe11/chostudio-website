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
        Schema::create('commisions', function (Blueprint $table) {
            $table->id('commission_id'); // PK
            $table->unsignedBigInteger('member_id'); // FK ke members.member_id tanpa constraint
            $table->string('category', 50);
            $table->text('description');
            $table->date('deadline')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('payment_status', ['pending', 'dp', 'paid', 'refunded'])->default('pending');
            $table->enum('progress_status', ['pending', 'accepted', 'in_progress_sketch', 'in_progress_coloring', 'review', 'revision', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commisions');
    }
};
