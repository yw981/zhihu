<?php
/**
 * Created by PhpStorm.
 * User: ytc
 * Date: 2018/9/17
 * Time: 下午4:30
 */

namespace App\Repositories;

use App\Question;
use App\Topic;

class QuestionRepository
{
    use NormalizeTopic;

    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id',$id)->with(['topics',])->first();
    }

    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Question::find($id);
    }

    /**
     * @return mixed
     */
    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getQuestionCommentsById($id)
    {
        $question = Question::with('comments','comments.user')->where('id',$id)->first();
        return $question->comments;
    }

}