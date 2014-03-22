<?php
class Vehicle extends Eloquent {
	protected $table = 'vehicle';
	protected $primaryKey = 'id_vehicle';
	public $timestamps = false;
	protected $fillable = array (
			'make',
			'model',
			'VIN',
			'year',
			'id_client',
			'id_insurance'
	);
	

}