<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //Storage::disk('qiniu')->writeStream($filename,fopen($file->getRealPath(),'r'));
        $file->move(public_path('avatars'),$filename);

        $user->avatar = $filename;
        //$user->avatar = asset(public_path('avatars/'.$filename));
        $user->save();

        // 返回给Vue组件
        return ['url' => $user->avatar];

//        $file = $request->file('img');
//        $filename = 'avatars/'.md5(time().user()->id).'.'.$file->getClientOriginalExtension();
//        Storage::disk('qiniu')->writeStream($filename,fopen($file->getRealPath(),'r'));
//        user()->avatar = 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename;
//        user()->save();
//        return ['url' => user()->avatar];
    }

}
