<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublishNotifyRequest;
use App\Http\Services\LineNotifyService;
use App\publishNotifyLog;
use App\TokenSetting;
use Illuminate\Http\JsonResponse;

class LineNotifyController extends Controller
{
    /** @var LineNotifyService */
    private $service;

    public function __construct(LineNotifyService $service)
    {
        $this->service = $service;
    }

    //紀錄發送歷史並且呼叫lineApi發送訊息
    public function pushNotify(PublishNotifyRequest $request)
    {
        $data = $request->validated();

        $this->writeLog($data);

        $data = $this->service->publishNotify($data);
    }

    //獲得金鑰
    public function getTokens(): JsonResponse
    {
        return response()->json($this->service->getTokens());
    }

    //紀錄發送歷史
    private function writeLog(array $data) {
        publishNotifyLog::query()->create([
            'name' => $data['user'],
            'message' => $data['message'],
            'chat_name' => TokenSetting::query()->find($data['token_id'])->name
        ]);
    }
}
