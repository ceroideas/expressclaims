<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('preUploadImage', 'WebAppController@preUploadImage');

Route::post('upload', 'ApiController@upload');
Route::post('uploadVideo', 'ApiController@uploadVideo');

Route::post('login', 'ApiController@login');
Route::get('logout/{id}', 'ApiController@logout');
Route::post('registration', 'ApiController@registration');
Route::post('registrationStreet', 'ApiController@registrationStreet');

Route::get('loadMessages/{id}/{destId}','ApiController@loadMessages');
Route::post('saveMessage','ApiController@saveMessage');

Route::post('saveLocation', 'ApiController@saveLocation');
Route::post('savePhoto', 'ApiController@savePhoto');
Route::post('uploadImage', 'ApiController@uploadImage');
Route::post('uploadImageB', 'ApiController@uploadImageB');
Route::post('uploadFileImage', 'ApiController@uploadFileImage');
Route::post('sendSMS', 'ApiController@sendSMS');

Route::post('saveRegistrationId', 'ApiController@saveRegistrationId');

Route::get('loadRequests/{id}', 'ApiController@loadRequests');
Route::post('sendRequest', 'ApiController@sendRequest');
Route::get('getUser/{id}', 'ApiController@getUser');
Route::get('getOperatorId/{id}', 'ApiController@getOperatorId');
Route::get('checkSteps/{id}', 'ApiController@checkSteps');
Route::post('sendInformation', 'ApiController@sendInformation');
Route::post('uploadImage2', 'ApiController@uploadImage2');
Route::post('saveInformation', 'ApiController@saveInformation');
Route::post('uploadFile', 'ApiController@uploadFile');
Route::post('adminUploadVideo', 'BackController@uploadVideo');
Route::post('saveDuration', 'BackController@saveDuration');
Route::post('downloadVideo', 'BackController@downloadVideo');
Route::get('downloadVideo', 'BackController@downloadVideo');

Route::post('uploadSnapshot', 'ApiController@uploadSnapshot');

Route::post('sendCode', 'ApiController@sendCode');
Route::post('checkCode', 'ApiController@checkCode');

Route::post('changePassword', 'ApiController@changePassword');

Route::post('saveNumber', 'ApiController@saveNumber');

Route::get('checkCall/{id}', 'ApiController@checkCall');
Route::get('reloadUser/{id}', 'ApiController@reloadUser');
Route::get('loadSinister/{id}', 'ApiController@loadSinister');
Route::get('checkUser/{id}', 'ApiController@checkUser');
Route::post('getTime', 'ApiController@getTime');

/****/

Route::post('authentication', 'ApiController@authentication');

// Route::get('updateDestId/{id}', 'ApiController@updateDestId');

Route::post('check', 'ApiController@check');
Route::post('checkBack', 'ApiController@checkBack');
/**/
Route::post('createSubproduct', 'ApiController@createSubproduct');
/**/

Route::post('checkBackReasign', 'ApiController@checkBackReasign');
Route::get('deleteBack/{id}', 'ApiController@deleteBack');
Route::post('getClaims', 'ApiController@getClaims');

Route::get('getClaim/{claim_id}', 'ApiController@getClaim');
Route::get('deleteSub/{claim_id}', 'ApiController@deleteSub');

Route::post('closeSin', 'ApiController@closeSin');
Route::post('notFinished', 'ApiController@notFinished');

Route::post('closeSelected', 'ApiController@closeSelected');

Route::post('uploadVideoTech', 'ApiController@uploadVideoTech');
Route::post('uploadAudioTech', 'ApiController@uploadAudioTech');
Route::post('uploadFileImageTech', 'ApiController@uploadFileImageTech');
Route::post('uploadExtraFileImageTech', 'ApiController@uploadExtraFileImageTech');
Route::post('uploadExtraFileImage', 'ApiController@uploadExtraFileImage');
Route::post('getClaimMedia', 'ApiController@getClaimMedia');
Route::post('deleteFile', 'ApiController@deleteFile');

Route::get('loadInformation/{id}', 'ApiController@loadInformation');
Route::post('uploadInformation', 'ApiController@uploadInformation');

Route::get('getOperator/{id}', 'ApiController@getOperator');

Route::post('searchStrertOperator', 'ApiController@searchStrertOperator');
/**/
Route::get('techDeviceId/{device_id}/{id}', 'ApiController@techDeviceId');
/**/
Route::post('saveOfflineClaims', 'ApiController@saveOfflineClaims');
/**/
Route::post('addBalance', 'ApiController@addBalance');
/**/
Route::post('upload_ticket', 'ApiController@upload_ticket');

Route::post('convertMp4', 'ApiController@convertMp4');

Route::post('perizia', 'BackController@changeMIData');

Route::post('mapI', 'BackController@mapI');
Route::post('autoassign', 'ApiController@autoassign');
Route::post('changeSociety', 'ApiController@changeSociety');

Route::get('getTypologies', 'ApiController@getTypologies');
Route::get('getSections/{id}', 'ApiController@getSections');

/**/

Route::post('uploadExternalImageTech', 'ApiController@uploadExternalImageTech');

Route::get('testImage', 'ApiController@testImage');