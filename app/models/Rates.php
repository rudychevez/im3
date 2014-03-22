<?php
class Rates extends Eloquent {
	protected $table = 'rates';
	protected $primaryKey = 'id_rates';
	public $timestamps = false;
	protected $fillable = array (
			'rates_name',
			'price',
			'id_company',
			'description'
	);
	
	public static function getRatesForSelect ($IdCompany) {
		return array ('' => '') + static::where ('id_company', '=', $IdCompany)->orderBy ('rates_name', 'ASC')->lists ('rates_name', 'id_rates');
	}
}