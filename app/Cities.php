<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
   	protected $table = 'cities';
   	/**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'id';


    protected $fillable = [
    	'id',
    	'country_id',
    	'name',
    ];
}
