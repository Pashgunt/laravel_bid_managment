<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function store(Request $request)
    {
        $user = auth('api')->user();
        if ($user && auth('api')->check()) return response(compact('user'));

        $id = $request->input('id');
        $user = User::find($id)->get();
        if ($user) {
            $token = User::find($id)->createToken('main')->accessToken;
            return response(compact('token', 'user'));
        }

        return $this->prepareErrorResponse([
            'result' => 'Something going wrong'
        ]);
    }
}
