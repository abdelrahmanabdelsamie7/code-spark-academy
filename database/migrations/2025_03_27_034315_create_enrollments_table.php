<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('course_id')->constrained('courses')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->enum('payment_method', ['vodafone_cash', 'paypal'])->nullable();
            $table->string('receipt_image')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
