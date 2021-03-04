<?php


namespace EG\Hospital\Models;


use EG\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends BaseModel
{
    protected $table = 'hs_appointments';

    protected $fillable = [
        'patient_name',
        'patient_phone',
        'patient_email',
        'appointment_date',
        'message',
        'department_id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault();
    }
}
