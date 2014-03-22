<?php
class Image extends Eloquent {
	protected $table = 'image';
	public $timestamps = false;
	protected $primaryKey = 'id_image';
	protected $fillable = array (
			'image_name',
			'id_table',
			'table_name'
	);
}