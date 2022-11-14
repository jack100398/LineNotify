<?php

use App\Http\Requests\EditUserSettingRequest;
use App\publishNotifyLog;
use App\User;
use App\UserDefaultToken;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user','LineNotifyController@pushNotify');

//發送訊息
Route::post('/publish','LineNotifyController@pushNotify');
//獲得所有金鑰
Route::get('/publish','LineNotifyController@getTokens');

//獲得所有金鑰
Route::get('/setting','SettingController@index');
//儲存新金鑰
Route::post('/setting','SettingController@store');
//刪除金鑰設定
Route::delete('/setting/{setting}','SettingController@destory');

//獲得發送歷史
Route::get('/history', function () {
    return publishNotifyLog::query()->orderby('created_at', 'DESC')->simplePaginate(15);
});

//獲得所有使用者(不包含admin)
Route::get('/users', function () {
    return User::query()->where('name', '<>', 'admin')->get();
});

//更新使用者
Route::patch('/user-setting/{user}', function (user $user, EditUserSettingRequest $request) {
    $data = $request->validated();
    if(Arr::get($data,'password')) {
        $user->update(
            [
                'password' => Hash::make($data['password'])
            ]
        );
    }

    if(Arr::get($data,'tokenId')) {
        UserDefaultToken::updateOrCreate(['user_id'=>$user->id],['token_id' => $data['tokenId']]);
    }
    
    return response()->json('successful');
});

//刪除使用者
Route::delete('/users/{user}', function (User $user) {
    $user->delete();
    return response()->json('successful');
});

