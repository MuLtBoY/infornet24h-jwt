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
        Schema::create('purveyor_assistance', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('purveyor_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('assistance_id')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('start_km');
            $table->decimal('start_value', 10, 2);
            $table->decimal('value_km', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purveyor_assistance');
    }
};
