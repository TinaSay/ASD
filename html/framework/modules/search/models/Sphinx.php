<?php

namespace app\modules\search\models;

use yii\helpers\ArrayHelper;

/**
 * Class Sphinx
 *
 * Замена strong на span в before_match и after_match
 */
class Sphinx extends \krok\search\models\Sphinx
{
    /**
     * @param array $filter
     *
     * @return \yii\sphinx\Query
     */
    public function find(array $filter)
    {
        $query = $this->finder->find($filter);

        $term = ArrayHelper::getValue($filter, 'term');

        $query->match($term)->limit(1000);
        $query->options([
            'field_weights' => ['title' => 90, 'data' => 10],
            'ranker' => 'sph04',
        ])->snippetCallback(function ($rows) {
            $snippets = [];
            foreach ($rows as $row) {
                $snippets[] = $row['description'];
            }

            return $snippets;
        })->snippetOptions([
            'before_match' => '<span>',
            'after_match' => '</span>',
        ]);

        return $query;
    }
}
