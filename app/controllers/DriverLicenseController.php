<?php

class DriverLicenseController extends BaseController
{
	protected $layout               = 'layout.default';
	private $typesAllow = array ( 'jpg', 'jpeg' );
	private $sizeAllow = 2800000;
	
	
	public function addPhotoDriverLicense( $IdClient )
	{
	
		if ( Input::hasFile( 'driver_license' ) ) {
				
			$fileMine = Input::file( 'driver_license' )->getClientOriginalExtension();
			$fileSize = Input::file( 'driver_license' )->getSize();
				
			if (!in_array( strtolower( $fileMine ), $this->typesAllow)) {
				
				$message = 'File type not allow';
				
			} elseif ( $fileSize > $this->sizeAllow ) {
				
				$message = 'Too much large, max size allow is 1mb';
				
			} else {
				
				$message = 'Photo added';
	
				$file_name = uniqid()  . '.jpg';
					
				Input::file( 'driver_license' )->move( './driver_license', $file_name);
	
				$driverLicenseInput = array( 'file_name' => $file_name, 'id_client' => $IdClient );
	
				DriverLicense::create($driverLicenseInput);

			}
			
			return Redirect::to ( 'client/driver-license/' . $IdClient )->with ( 'message', $message );
	
		} else {
			$this->layout->content = View::make ( 'client.driver_license' )->with( 'IdClient', $IdClient );
		}
	}
	
	public function driverLicense ( $IdClient )
	{
		$driverLicense = DriverLicense::where( 'id_client', '=', $IdClient ) ->get();
		
		return View::make ( 'client.driver_license', array ( 'driver_license' => $driverLicense ) )->with( 'IdClient', $IdClient );
	}
}