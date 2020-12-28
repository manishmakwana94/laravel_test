<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
   	protected $table = 'countries';
   	/**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'id';


    protected $fillable = [
    	'id',
    	'name',
    ];
}
