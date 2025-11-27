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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Link this booking to a User. 
            // 'cascade' means if you delete the user, delete their bookings too.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Information about what they booked
            $table->string('item_key');  // e.g. 'studio' (used for logic)
            $table->string('item_name'); // e.g. 'Studio Apartment' (used for display)
            $table->decimal('price', 10, 2); // e.g. 499.00
            
            $table->timestamps();

            // SUPER IMPORTANT: This line makes it impossible for 
            // the same user to have two rows with the same 'item_key'.
            $table->unique(['user_id', 'item_key']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};