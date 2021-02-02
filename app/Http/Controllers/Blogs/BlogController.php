<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    //
    public function getBlogs ()
    {
        $sql = "select blog_id,blog_title,create_date from blogs where deleted=1";
        $data = DB::select($sql);
        $req = [
            'code'=>200,
            'message'=>'查询成功',
            'data'=>$data
        ];
        return json_encode($req);
    }

    public function getBlogDetail(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return [
                'code'=>401,
                'data'=>'',
                'message'=>'参数id必传'
            ];
        }
        $sql = "select blog_id,blog_title,blog_content from blogs where deleted=1 and blog_id=?";
        $data = DB::select($sql, array($id))[0];
        return [
            'code'=>200,
            'data'=>$data,
            'message'=>'查询成功'
        ];
    }

    public function writeBlogs (Request $request)
    {
        $token = $request -> header('token');
        if(!$token){
            $req = [
                'code'=>401,
                'message'=>'请登录后操作'
            ];
            return $req;
        }
        $id = Cache::get($token);
        if(!$id){
            $req = [
                'code'=>401,
                'message'=>'token失效'
            ];
            return $req;
        }
        $title = $request -> input('blog_title');
        $content = $request -> input('blog_content');
        if($title && $content){
            $sql = "insert into blogs(blog_title, blog_content, user_id, deleted, create_date) values(?,?,?,?,?)";
            $msg = DB::insert($sql, array($title, $content, $id, 1, date('Y-m-d H:i:s',time())));
            if($msg){
                return [
                    'code'=>200,
                    'message'=>'发布成功'
                ];
            }else{
                return [
                    'code'=>401,
                    'message'=>'发布失败'
                ];
            }
        }else{
            return [
                'code'=>401,
                'message'=>"入参不完整"
            ];
        }
    }
}
