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
        return Question::published()->latest('updated_at')->with('user')->get();
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

    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            // 如果是数字，说明是id，已有的topic
            if ( is_numeric($topic) ) {
                // 问题数量+1
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            // 不是数字，新建话题
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

}