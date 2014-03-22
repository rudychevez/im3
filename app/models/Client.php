<?php
class Client extends Eloquent {
	protected $table = 'client';
	protected $primaryKey = 'id_client';
	protected $fillable = array (
			'client_name',
			'last_name',
			'telephone',
			'address',
			'zip_code',
			'city',
			'state',
			'driver_license' 
	);
	
	public static function getClientName ($IdClient)
	{
		$client = static::find($IdClient);
		return $client->client_name . ' ' . $client->last_name;
	}
	
	public function vehicle()
	{
		return $this->hasMany ( 'Vehicle', 'id_client' );
	}
	
	public function insurance()
	{
		return $this->hasMany ( 'Insurance', 'id_client' );
	}
	
	public function getClientNameAttribute($value)
	{
		return strtoupper ($value);
	}
	
	public function setClientNameAttribute($value)
	{
		$this->attributes['client_name'] = strtoupper ($value);
	}
	
	public function getLastNameAttribute($value)
	{
		return strtoupper ($value);
	}
	
	public function setLastNameAttribute($value)
	{
		$this->attributes['last_name'] = strtoupper ($value);
	}
}