<?php

namespace App\Http\Services;

use App\TokenSetting;
use Illuminate\Database\Eloquent\Collection;

class LineNotifyService
{
    //透過官方Line Notify Api請求發送訊息
    public function publishNotify(array $data): array
    {
        $token = TokenSetting::query()->find($data['token_id'])->token;

        $headers = array(
            "Content-Type: multipart/form-data",
            "Authorization: Bearer {$token}"
        );
        $message = array(
            'message' => $data['message']
        );
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        $result = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    //獲得金鑰
    public function getTokens(): Collection
    {
        return TokenSetting::query()->get()->makeHidden('token');
    }
}
