<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function avatar()
    {
        return view('users.avatar');
    }

    public function changeAvatar(Request $request)
    {
        $file = $request->file('img');
        $user = $request->user();

        $filename = 'avatars/'.md5(time().$user->id).'.'.$file->getClientOriginalExtension();

        // 七牛云存储
        Storage::disk('qiniu')->writeStream($filename,fopen($file->getRealPath(),'r'));

        // 本地存储，如果使用，请把七牛的两行注释掉
        // $file->move(public_path('avatars'),$filename);
        // $user->avatar = $filename;

        // 七牛云存储
        $user->avatar = 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename;

        $user->save();

        // 返回给Vue组件
        return ['url' => $user->avatar];

    }

}
