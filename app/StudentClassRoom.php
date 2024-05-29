<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClassRoom extends Model
{
    protected $table = 'student_class';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'class_id', 'created_by', 'created_date'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function class()
    {
        return $this->belongsTo(ClassRoom::class,'class_id','id');
    }
}
