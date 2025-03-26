<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->integer('duration');
            $table->integer('sessions_count');
            $table->string('image')->nullable();
            $table->enum('mode', ['online', 'offline'])->default('online');
            $table->decimal('price', 8, 2)->nullable()->default(0.00);
            $table->unsignedInteger('discount')->nullable()->default(0);
            $table->enum('status', ['available', 'closed', 'completed'])->default('available');
            $table->foreignUuid('instructor_id')->nullable()->constrained('instructors')->nullOnDelete();
            $table->foreignUuid('track_id')->nullable()->constrained('tracks')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
