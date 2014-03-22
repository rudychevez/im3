function getVehicleModel() {
	var vehicleMake = encodeURIComponent ( $( '#make' ).val () );
	
	$( '#vehicle_model' ).load ( '/ajax/vehicle-model/' + vehicleMake );
}

function getInsuranceRates() {
	var insuranceCompany = $( '#id_company' ).val ();
	
	$( '#insurance_company' ).load ( '/ajax/insurance-rates/' + insuranceCompany );
}

function cancelInsurance() {
	var cfmCancel = confirm('De verdad quieres cancelar esta cosa?');
	if (cfm == true) {
		window.location = 'insurance/';
	}
}