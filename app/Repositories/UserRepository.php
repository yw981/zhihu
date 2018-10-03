<?php
/**
 * Created by PhpStorm.
 * User: ytc
 * Date: 2018/10/3
 * Time: 下午9:30
 */

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return User::find($id);
    }
}