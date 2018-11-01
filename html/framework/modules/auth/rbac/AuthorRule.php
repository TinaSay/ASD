<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 10.11.15
 * Time: 20:18
 */

namespace app\modules\auth\rbac;

use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

/**
 * Class AuthorRule
 *
 * @package app\modules\auth\rbac
 */
class AuthorRule extends Rule
{
    /**
     * @var string
     */
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated width
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     *
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $model = ArrayHelper::toArray(ArrayHelper::getValue($params, 'model', []));

        return isset($model['createdBy']) ? $model['createdBy'] == $user : false;
    }
}
