<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class testController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'error' => [
            'message' => $error,
            'code' => $code,
        ]];
        if(!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
   public function createUser (Request $request)
   {
        $data = $request->toArray();
       $validator = Validator::make($request->toArray(), [
           'fio' => 'required',
           'email' => 'required|email',
           'password' => 'required|min:6',
       ]);
       if($validator->fails()){
           return $this->sendError('Validation Error.', $validator->errors());
       }
       $apiToken = Str::random(60);
       User::create([
           'name' => $data['fio'],
           'email' => $data['email'],
           'password' => Hash::make($data['password']),
           'api_token' => $apiToken,
       ]);
       return $this->sendResponse($request->toArray(), 'Юзер создан');
   }
    public function loginUser (Request $request)
    {
        if(!$_SERVER['HTTP_AUTHORIZATION']) return $this->sendError('Отсутствует токен',[],403);
        $data = $request->toArray();
        $validator = Validator::make($request->toArray(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('email',$data['email'])->first();

        if (!$user) return $this->sendError('Пользователь не найден',[],401);
        if (Hash::check($data['password'],$user['password'])) {
            return $this->sendResponse($user['api_token'], 'Вы авторизованы');
        }

    }
   /*public function authorize()
   {
       return 1;
   }*/
}
