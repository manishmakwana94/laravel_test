<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
   	protected $table = 'students';
   	/**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'id';


    protected $fillable = [
    	'id',
    	'student_name',
    	'address',
    	'grade',
    	'photo',
        'date_of_birth',
    	'city_id',
    	'country_id',
    	'is_active',
    ];
}
