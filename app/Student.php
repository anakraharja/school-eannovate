<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'age', 'phone_number', 'picture', 'created_by', 'modified_by', 'created_date', 'modified_date'
    ];

    public function student_class()
    {
        return $this->hasMany(StudentClassRoom::class);
    }
    public function scopeClassId($query, $id)
    {
        return $query->WhereHas('student_class',function($query) use ($id){
            $query->where('class_id',$id);
        });
    }
    public function createdby()
    {
        return $this->belongsTo(Admin::class,'created_by','id');
    }
    public function modifiedby()
    {
        return $this->belongsTo(Admin::class,'modified_by','id');
    }
}
