<?php
class VehicleMake extends Eloquent {
	protected $table = 'vehicle_make';
	protected $primaryKey = 'id_vehicle_make';
	
	public function models() {
		return $this->hasMany ('VehicleModel', 'make')->get ('id_vehicle_model', 'model');
	}
	
	public static function getMake ()
	{
		$data [''] = '';
		
		foreach (static::all() as $m) {
			$data [$m->make] = $m->make;
		}
		
		return $data;
	} 
}