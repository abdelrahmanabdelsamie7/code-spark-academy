<?php
namespace App\Models;
use App\Models\{User,Course};
use App\traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory,UsesUuid;
     protected $fillable = [
        'user_id',
        'course_id',
        'amount_paid',
        'payment_method',
        'receipt_image',
        'payment_status',
        'enrolled_at',
    ];
    protected $casts = [
        'enrolled_at' => 'datetime',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    protected function receiptImage()
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/' . $value) : null
        );
    }
}