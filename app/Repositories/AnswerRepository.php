<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2018/9/29
 * Time: 下午3:58
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{

    /**
     * @param array $attributes
     * @return \App\Answer
     */
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Answer::find($id);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments', 'comments.user')->where('id', $id)->first();
        return $answer->comments;
    }

}