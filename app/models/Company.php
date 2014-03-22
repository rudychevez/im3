<?php
class Company extends Eloquent {
	protected $table = 'company';
	protected $primaryKey = 'id_company';
	public $timestamps = false;
	protected $fillable = array (
			'company_name',
			'id_branch'
	);
	
	public function rates ()
	{
		return $this->hasMany ('Rates', 'id_company')->orderBy ('rates_name', 'ASC');
	}
	
	public static function getCompany ()
	{
		return array ('' => '') + Company::where ('id_branch', '=', Auth::user ()->id_branch)->orderBy ('company_name', 'ASC')->lists ('company_name', 'id_company');
	}
}