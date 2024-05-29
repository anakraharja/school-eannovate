<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'class';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'major', 'created_by', 'modified_by', 'created_date', 'modified_date'
    ];

    public function student_class_room()
    {
        return $this->hasMany(StudentClassRoom::class);
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
