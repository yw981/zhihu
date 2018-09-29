<?php
/**
 * Created by PhpStorm.
 * User: ytc
 * Date: 2018/9/17
 * Time: 下午4:30
 */

namespace App\Repositories;

use App\Topic;

trait NormalizeTopic
{
    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopic($topics)
    {
        if(!isset($topics) || empty($topics)) return [];
        return collect($topics)->map(function ($topic) {
            // 如果是数字，说明是id，已有的topic
            if ( is_numeric($topic) ) {
                // TODO count数量+1
                // Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            // 不是数字，新建话题
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

}