<?php
class DriverLicense extends Eloquent {
	protected $table    = 'driver_license';
	public $timestamps  = false;
	protected $fillable = array (
			'file_name',
			'id_client'
	);
	
}