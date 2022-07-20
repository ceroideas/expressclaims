<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*ENDPOINT*/
Route::get('assegna', 'BackController@assegna');

Route::post('alignExperts', 'BackController@alignExperts');
Route::post('alignStates', 'BackController@alignStates');
/**/
Route::post('multiple-modal', 'BackController@multipleModal');
Route::get('data-modal/{id}', 'BackController@dataModal');
Route::post('exportExcel', 'BackController@exportExcel');

//
Route::post('saveModalData', 'BackController@saveModalData');

Route::get('loadRest', 'VideoCallsController@loadRest');

Route::get('webapp', 'WebAppController@webapp');

Route::get('autoperizia', 'WebAppController@autoperizia');
Route::post('preUploadImage', 'WebAppController@preUploadImage');


Route::post('saveAutoperiziaLocation', 'WebAppController@saveAutoperiziaLocation');
Route::post('saveAutoperiziaData', 'WebAppController@saveAutoperiziaData');

Route::post('saveWebappUserLocation', 'WebAppController@saveWebappUserLocation');

Route::post('sendPoll/{id}', 'WebAppController@sendPoll');
Route::post('setCompanySession', 'BackController@setCompanySession');
Route::get('findMapInformation/{id}', 'BackController@findMapInformation');

Route::get('ping', function() {
    //
    return "Connected";
});

Route::get('/', function () {
    return redirect('admin/dashboard');
	// if (Auth::user()->role_id == 1) {
 //        return redirect('/admin/videocalls');
        
 //    }
 //    if (Auth::user()->role_id == 2) {
 //        return redirect('/admin/express-tech/elenco');
        
 //    }
 //    if (Auth::user()->role_id == 3) {
 //        return redirect('/admin/mappa');
        
 //    }if (Auth::user()->role_id == -1) {
 //        return redirect('/admin/sinister');
 //    }
 //    return redirect('admin/requests');
});
Route::get('/logout/{id?}', function($id = null){
	Auth::logout();
	if ($id) {
		return redirect('admin/login')->with('warning', 'La tua sessione è stata chiusa per inattività, accedi di nuovo');
	}
	return redirect('admin/requests');
});
Route::get('/short/{id}', 'WebAppController@short');
Route::get('/pruebas/{limit?}', 'ApiController@migrar');
Route::post('getTime', 'BackController@getTime');
Route::post('find_company', 'BackController@find_company');

Route::post('uploadFileChat', 'BackController@uploadFileChat');

Route::get('utente/{id}/{o}/{res}/{sha1}', 'BackController@utente');
Route::get('videos/{s1}/{id}','BackController@videosU');
Route::get('images/{s1}/{id}','BackController@imagesU');

Route::post('uploadExcel','BackController@uploadExcel');
Route::post('getMapInformation','BackController@getMapInformation');
Route::post('getMapInformationG','BackController@getMapInformationG');
Route::post('getMapInformation2','BackController@getMapInformation2');
Route::post('getMapInformation3','BackController@getMapInformation3');
Route::post('retrieveRestantes','BackController@retrieveRestantes');

Route::post('saveExcelData','BackController@saveExcelData');

Route::get('exportTable','BackController@exportTable');

Route::post('changeMonth-full', 'BackController@changeMonthFull');


// Route::post('inviteEvent', 'BackController@inviteEvent');
Route::post('deleteEvent', 'BackController@deleteEvent');

Route::group(['prefix' => 'admin'], function() {

	Route::get('calendario', 'BackController@calendario');
	Route::get('exportOperators/{status}', 'BackController@exportOperators');
	/**/

	Route::post('autoperizia-export', 'BackController@autoperiziaExport');
	Route::post('autoperizia-export-full', 'BackController@autoperiziaExportFull');
	Route::post('autoperizia-export-all/{id}', 'BackController@autoperiziaExportAll');
	Route::get('autoperizia-export-zip/{id}', 'BackController@autoperiziaZip');

	/**/

	Route::get('/', function() {
	    return redirect('admin.dashboard');
	});

	Route::post('saveLatLng/{id}', 'BackController@saveLatLng');
	Route::get('mappa', function(){
		// return App\MapInformation::first();
		return view('admin.maps');
	});

	Route::get('situazione-generale', function(){
		return view('admin.map-gestion');
	});

	Route::get('web-app/{id?}', 'WebAppController@index');
	Route::get('web-app-2/{id?}', 'WebAppController@index2');
	Route::post('web-app/{id?}', 'WebAppController@save');
	Route::get('web-app/delete/{id?}', 'WebAppController@delete');

	Route::get('self-management-links/{id?}', 'WebAppController@indexSML');
	Route::get('self-management-links-2/{id?}', 'WebAppController@indexSML2');
	Route::get('self-management', 'WebAppController@indexSM');
	Route::get('self-management-closed', 'WebAppController@indexSMC');
	Route::get('self-management-data/{id}', 'WebAppController@indexSMD');
	Route::post('self-management/{id?}', 'WebAppController@saveSM');
	Route::get('self-management/delete/{id?}', 'WebAppController@deleteSM');

	Route::get('close-self-management/{id}', 'WebAppController@closeSM');

	Route::post('changeOrder', 'BackController@changeOrder');
	Route::post('changeOrderClaims', 'BackController@changeOrderClaims');
	Route::post('changeName', 'BackController@changeName');
	Route::post('updateAddress', 'BackController@updateAddress');
	Route::post('updateAddressClaims', 'BackController@updateAddressClaims');
	Route::post('updateAddressAutoperizia', 'BackController@updateAddressAutoperizia');

	Route::get('deleteSms/{id}', 'BackController@deleteSms');

	Route::post('saveInformation','BackController@saveInformation');
	Route::post('smspassword','BackController@smspassword');

	Route::post('loadMessages','VideoCallsController@loadMessages');

	Route::get('login',['as' => 'login', 'uses' => 'LoginController@login']);
	Route::post('login',['as' => 'login', 'uses' => 'LoginController@auth']);

	Route::group(['middleware' => 'auth'], function() {

		Route::get('/dashboard', function() {
		    return view('admin.index');
		});

		Route::get('videochiamate-mensili', 'BackController@videochiamateMensili');

		Route::get('express-tech/emails', 'BackController@emails');
		Route::get('express-tech/delete-mail/{id}', 'BackController@delete_mail');
		Route::get('express-tech/edit-mail/{id}', 'BackController@editemails');
		Route::post('express-tech/emails', 'BackController@saveemail');
		Route::post('express-tech/update-emails', 'BackController@updateemail');

		Route::get('express-tech/elenco', 'BackController@expressTech');
		Route::get('express-tech/chiusi', 'BackController@expressTechChiusi');
		Route::get('express-tech/media/{id}', 'BackController@expressTechMediaView');

		Route::post('express-tech-export', 'BackController@expressTechExport');
		Route::post('express-tech-export-full', 'BackController@expressTechExportFull');
		Route::get('express-tech-export-all/{sin_number}/{location?}/{empresa?}', 'BackController@expressTechExportAll');
		Route::get('express-tech-export-zip/{id}', 'BackController@expressTechZip');

		Route::get('express-tech-close/{id?}', 'BackController@expressTechClose');

		Route::group(['middleware' => 'superadmin'], function() {
			Route::post('express-claims-export', 'BackController@expressClaimsExport');
			Route::post('express-claims-export-full', 'BackController@expressClaimsExportFull');
			Route::post('express-claims-export-all/{id}', 'BackController@expressClaimsExportAll');
			Route::get('express-claims-export-zip/{id}', 'BackController@expressClaimsZip');

			Route::get('/', 'BackController@index');

			Route::post('/share', 'BackController@share');
			Route::post('/reopen', 'BackController@reopen');

			Route::get('/push', 'BackController@push');
			Route::post('/push', 'BackController@send_push');
			Route::post('/send-msg-notification', 'BackController@send_msg_notification');
			Route::post('/send-call-notification', 'BackController@send_call_notification');
			Route::get('/predefiniti/{id?}', 'BackController@predefiniti');
			Route::get('/predefiniti/delete/{id}', 'BackController@delete_sms');

			Route::post('/sms/update/{id}', 'BackController@sms_update');
			Route::post('/sms/create/', 'BackController@sms_create');

			Route::get('/sms', 'BackController@sms');
			Route::post('/sms', 'BackController@send_sms');
			Route::get('/requests', 'BackController@requests');
			Route::get('/sinister', 'BackController@sinister');
			Route::get('/all-sinister', 'BackController@allSinister');
			Route::get('/historial','BackController@historial');
			Route::get('/my-customers','BackController@my_customers');
			Route::get('/preassign/{id?}','BackController@preassign');
			Route::post('/preassign/{id?}','BackController@savePreassign');
			Route::get('/preassign/delete/{id?}','BackController@deletePreassign');
			Route::get('/view-customer/{id}','BackController@view_customer');

			Route::post('/change_can_call','BackController@change_can_call');

			Route::resource('operators', 'OperatorsController');
			Route::get('operators/delete/{id}', 'OperatorsController@destroy');
			Route::resource('customers', 'CustomersController');
			Route::get('customers/delete/{id}', 'CustomersController@destroy');
			Route::resource('accertatore', 'StreetOperatorController');
			Route::get('accertatore/delete/{id}', 'StreetOperatorController@destroy');
			Route::get('accertatore/disable/{id}', 'StreetOperatorController@disable');

			Route::get('operators/disable/{id}', 'StreetOperatorController@disable');

			Route::get('videocalls','VideoCallsController@index');

			Route::get('see-user-status/{id}','VideoCallsController@user_status');
			Route::post('operator_call_id','VideoCallsController@operator_call_id');
			
			Route::post('saveMessage','VideoCallsController@saveMessage');

			Route::post('receiveImage','VideoCallsController@receiveImage');
			
			Route::post('deleteImage','VideoCallsController@deleteImage');
			
			Route::post('inCallNull','VideoCallsController@inCallNull');
			Route::post('inCallTrue','VideoCallsController@inCallTrue');
			Route::post('findInCall','VideoCallsController@findInCall');
			Route::post('save_record_data','VideoCallsController@save_record_data');
			Route::post('close-request/{id}','VideoCallsController@close_request');
			Route::post('create-sinister','BackController@create_sinister');
			Route::post('edit-sinister','BackController@edit_sinister');
			Route::post('save-sinister','BackController@save_sinister');

			Route::get('sinister/videos/{id}','BackController@videos');
			Route::get('sinister/images/{id}','BackController@images');

			Route::post('link-user/{id}','BackController@link_user');
			Route::post('uploadVideo','BackController@uploadVideo');

			Route::post('open_chat', 'BackController@open_chat');

			Route::get('compagnia/{id?}', 'BackController@compagnia');
			Route::get('modello-di-polizza/{id?}', 'BackController@modellodipolizza');
			Route::get('tipologia-di-danno/{id?}', 'BackController@tipologiadidanno');

			Route::post('compagnia/{id?}', 'BackController@compagniaPost');
			Route::post('modello-di-polizza/{id?}', 'BackController@modellodipolizzaPost');
			Route::post('tipologia-di-danno/{id?}', 'BackController@tipologiadidannoPost');

			Route::get('compagnia/delete/{id?}', 'BackController@compagniaDelete');
			Route::get('modello-di-polizza/delete/{id?}', 'BackController@modellodipolizzaDelete');
			Route::get('tipologia-di-danno/delete/{id?}', 'BackController@tipologiadidannoDelete');

			Route::get('deleteSinister/{id}', 'BackController@deleteSinister');
			
			Route::get('reopenSinister/{id}', 'BackController@reopenSinister');

			Route::post('startSearch', 'BackController@startSearch');



			Route::get('desactivarLink/{id}', 'BackController@desactivarLink');
		});
		Route::post('exportRecord', 'BackController@exportRecord');
		Route::get('changeParameter/{id}/{parameter}', 'BackController@changeParameter');
	});



});

Route::post('express-tech-export', 'BackController@expressTechExport');
Route::post('express-tech-export-full', 'BackController@expressTechExportFull');
Route::get('express-tech-export-all/{sin_number}/{location?}/{empresa?}', 'BackController@expressTechExportAll');
Route::get('express-tech-export-zip/{id}', 'BackController@expressTechZip');

Route::post('express-claims-export', 'BackController@expressClaimsExport');
Route::post('express-claims-export-full', 'BackController@expressClaimsExportFull');
Route::post('express-claims-export-all/{id}', 'BackController@expressClaimsExportAll');
Route::get('express-claims-export-zip/{id}', 'BackController@expressClaimsZip');

Route::post('changeOrder', 'BackController@changeOrder');
Route::post('changeOrderClaims', 'BackController@changeOrderClaims');
Route::post('updateAddress', 'BackController@updateAddress');
Route::post('updateAddressClaims', 'BackController@updateAddressClaims');

Route::get('tech-media/{id}', 'BackController@expressTechMediaView2');
Route::get('videoperizia-media/{id}', 'BackController@videoperiziaMediaView2');

Route::post('changeName', 'BackController@changeName');

Route::get('deleteClaimFile/{id}', 'BackController@deleteClaimFile');
Route::get('deleteFile/{id}', 'BackController@deleteFile');


Route::group(['middleware' => 'auth'], function() {

	Route::group(['prefix' => 'admin'], function() {

		Route::get('tipologie/{id?}', 'TypologiesController@index');
		Route::get('tipologie/sezioni/{id}', 'TypologiesController@index2');

		Route::get('addTemplate/{id}', 'TypologiesController@addTemplate');

		Route::post('add/{id?}', 'TypologiesController@add');
		Route::post('addSection', 'TypologiesController@addSection');
		Route::post('addInput', 'TypologiesController@addInput');
		Route::post('updateInput', 'TypologiesController@updateInput');
		Route::post('addOption', 'TypologiesController@addOption');

		Route::post('changeInputOrder', 'TypologiesController@changeInputOrder');
		Route::post('changeSectionOrder', 'TypologiesController@changeSectionOrder');
		Route::post('updateSection', 'TypologiesController@updateSection');

		Route::get('deleteQuestion/{id}', 'TypologiesController@deleteQuestion');
		Route::get('deleteTypology/{id}', 'TypologiesController@deleteTypology');
		Route::get('deleteSection/{id}', 'TypologiesController@deleteSection');
	});

});

Route::get('test', function() {
    return 'OK';
});

Route::get('addInfo/{id}', 'ExifController@index');
Route::get('addInfoClaims/{id}', 'ExifController@indexClaims');
Route::get('addInfoClaimsUser/{id}', 'ExifController@indexClaimsUser');


Route::get('textExif', 'ExifController@textExif');

Route::get('reload-all/{id}', 'BackController@reloadAll');

Route::get('setHour/{hour}', 'BackController@setHour');