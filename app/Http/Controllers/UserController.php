<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // 修改头像
    public function avatar()
    {
        return view('users.avatar');
    }

    public function updateAvatar(Request $request)
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

    // 修改密码
    public function password()
    {
        return view('users.password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        // TODO 需要增加Request Rule验证
        // 从Request获取当前登录用户，也可用Auth::user()或使用Helper
        $user = $request->user();
        if(Hash::check($request->get('old_password'),$user->password)) {
            $user->password = bcrypt($request->get('password'));
            $user->save();
            flash('密码修改成功','success');
            return back();
        }
        flash('密码修改失败','danger');
        return back();
    }

    // 用户设置
    public function setting()
    {
        // dd(Auth::user()->settings);
        return view('users.setting');
    }

    public function updateSetting(Request $request)
    {
        $request->user()->settings()->merge($request->all());
        return back();
    }

}
