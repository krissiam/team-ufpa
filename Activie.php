<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Activie.
 *
 * @author  The scaffold-interface created at 2017-08-29 08:05:22pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Activie extends Model
{
	
	
    public $timestamps = false;
    
    protected $table = 'activies';

	
	public function subgrupo()
	{
		return $this->belongsTo('App\Subgrupo','subgrupo_id');
	}

	
}
