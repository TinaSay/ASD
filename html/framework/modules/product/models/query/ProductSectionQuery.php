<?php

namespace app\modules\product\models\query;

use app\modules\product\models\Product;
use app\modules\product\models\ProductSection;
use krok\extend\widgets\tree\TreeActiveQuery;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\app\modules\product\models\ProductSection]].
 *
 * @see \app\modules\product\models\ProductSection
 */
class ProductSectionQuery extends TreeActiveQuery
{
    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductSection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductSection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere([
            ProductSection::tableName() . '.[[hidden]]' => ProductSection::HIDDEN_NO,
        ]);
    }

    /**
     * @return $this
     */
    public function hasProducts()
    {
        return $this->joinWith('products', false, 'INNER JOIN')
            ->andWhere([Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO]);
    }

    /**
     * @return array
     */
    public function asTree()
    {
        $key = [
            __CLASS__,
            __METHOD__ .
            __LINE__,
            $this->createCommand()->getRawSql(),
        ];

        $dependency = new TagDependency([
            'tags' => [
                ProductSection::class,
            ],
        ]);

        if (($list = Yii::$app->cache->get($key)) === false) {

            $list = $this->tree($this->queryTree());

            Yii::$app->cache->set($key, $list, null, $dependency);
        }

        return $list;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function queryTree()
    {
        return $this
            ->joinWith('brands', true)
            ->orderBy([
                'depth' => SORT_DESC,
                'position' => SORT_ASC,
            ])->asArray()->indexBy('id')->all();
    }

    /**
     * @param array $list
     *
     * @return array
     */
    private function tree(array $list)
    {
        foreach ($list as $row) {
            if (ArrayHelper::keyExists($row['parentId'], $list)) {
                $children = ArrayHelper::remove($list, $row['id']);
                $list[$row['parentId']] = ArrayHelper::merge($list[$row['parentId']], ['children' => [$children]]);
            }
        }

        return $list;
    }

    /**
     * @param $parentId
     * @param array $tree
     *
     * @return array
     */
    public function getAllChildrenId($parentId, $tree = [])
    {
        $ids = [];

        $tree = $tree ?: $this->asTree();

        foreach ($tree as $row) {
            if ($row['id'] == $parentId) {
                if (isset($row['children'])) {
                    $ids = ArrayHelper::getColumn($row['children'], 'id', []);

                    foreach ($row['children'] as $child) {
                        if (isset($child['children'])) {
                            $ids = array_merge($ids, $this->getAllChildrenId($child['id'], [$child]));
                        }
                    }

                    return $ids;
                } else {
                    return [];
                }
            }
        }

        return $ids;
    }

    /**
     * @param $childId
     * @return int|null
     */
    public function getRootId($childId)
    {
        $tree = $this->asTree();
        // this is root section
        if (isset($tree[$childId])) {
            return $childId;
        }

        $list = [];
        $this->treeList($tree, $list);

        foreach ($list as $row) {
            if ($row['id'] == $childId) {
                if ($row['parentId']) {
                    return $this->getRootId($row['parentId']);
                } else {
                    return $childId;
                }
            }
        }

        return $childId;
    }

    /**
     * Recursive transform Tree to List
     *
     * @param array $tree
     * @param array $list
     */
    private function treeList(array $tree, array &$list)
    {
        foreach ($tree as $row) {
            $list[] = $row;
            if (isset($row['children']) && is_array($row['children'])) {
                $this->treeList($row['children'], $list);
            }
        }
    }

}
