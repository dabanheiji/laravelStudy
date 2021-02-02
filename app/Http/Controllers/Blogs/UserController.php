<?php

namespace App\Http\Controllers\Blogs;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    //
    public function login (Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if(!($username && $password)){
            $data = [
                'code'=>400,
                'message'=>'请输入用户名或密码'
            ];
            return json_encode($data);
        }
        $sql = "select pwd,id from users where user_name=?";
        $pwd = DB::select($sql, [$username]);
        if(empty($pwd)){
            $data = [
                'code'=>400,
                'message'=>'用户名不存在'
            ];
            return json_encode($data);
        }
        $pwd = $pwd[0] -> pwd;
        $token = md5($username);
        if($password == $pwd){
            $data = [
                'code'=>200,
                'message'=>"登录成功",
                'token'=>$token
            ];
            $id = DB::select($sql, [$username])[0] -> id;
            Cache::put( $token, $id, 15000);
            return json_encode($data);
        }else{
            $data = [
                'code'=>401,
                'message'=>"密码不正确",
            ];
            return json_encode($data);
        }
    }
}
