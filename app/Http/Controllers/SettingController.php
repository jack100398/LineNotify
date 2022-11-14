<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTokenRequest;
use App\TokenSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        return Response()->json([
           TokenSetting::query()->get()
        ]);
    }

    public function store(CreateTokenRequest $request): JsonResponse
    {
        $data = $request->validated();
        TokenSetting::query()
            ->create(
                ['name' => $data['chat_name'],
                'token' => $data['robot_token']
            ]);
        return Response()->json($data, 201);
    }

    public function destory(TokenSetting $setting): JsonResponse
    {
        $setting->delete();
        return Response()->json('ok');
    }
}
