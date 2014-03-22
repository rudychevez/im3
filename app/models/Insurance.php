<?php
class Insurance extends Eloquent {
	protected $table      = 'insurance';
	public $timestamps    = false;
	protected $primaryKey = 'id_insurance';
	protected $fillable   = array (
			'id_company',
			'id_rates',
			'id_client',
			'policy_number',
			'start_at',
			'end_at' 
	);
	
	public function vehicle()
	{
		return $this->hasMany ( 'Vehicle', 'id_insurance' );
	}
	
	public function getStartAtAttribute($value)
	{
		return date('m-d-Y', strtotime($value));
	}
	
	public function setStartAtAttribute($value)
	{
		$this->attributes['start_at'] = date('Y-m-d', strtotime($value));
	}
	
	public function getEndAtAttribute($value)
	{
		return date('m-d-Y', strtotime($value));
	}
	
	public function setEndAtAttribute($value)
	{
		$this->attributes['end_at'] = date('Y-m-d', strtotime($value));
	}
}