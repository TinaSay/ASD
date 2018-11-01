<?php

namespace app\commands;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\rbac\BaseManager;
use yii\rbac\Rule;
use yii\web\IdentityInterface;

/**
 * Class AccessController
 *
 * @package app\commands
 */
class AccessController extends \yii\console\Controller
{
    /**
     * @var array
     */
    public $login = [];

    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var array
     */
    public $protectedRoles = [];

    /**
     * @var array
     */
    public $modules = [];

    /**
     * @var array
     */
    public $defaultMethodIds = [
        'index',
        'create',
        'view',
        'update',
        'delete',
    ];

    /**
     * @var string
     */
    public $prefix = '';

    /**
     * @var string
     */
    public $separator = '/';

    /**
     * @var string
     */
    public $manager = 'authManager';

    /**
     * @var null|ActiveRecord|IdentityInterface
     */
    public $user = null;

    /**
     * @var null|BaseManager
     */
    protected $rbac = null;

    public function init()
    {
        parent::init();
        $this->rbac = Yii::$app->get($this->manager);
        $this->user = Yii::createObject($this->user);

        if (!($this->rbac instanceof BaseManager)) {
            throw new InvalidConfigException('The "rbac" property must be set.');
        }

        if (!($this->user instanceof IdentityInterface)) {
            throw new InvalidConfigException('The "user" property must be set.');
        }
    }

    /**
     * @return int
     */
    public function actionInstall()
    {
        $this->make();
        $this->installRules();
        $this->installItems();

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * @throws InvalidConfigException
     */
    private function make()
    {
        $modules = [];

        if (is_array($this->modules)) {
            foreach ($this->modules as $module) {

                $moduleId = ArrayHelper::getValue($module, 'name');
                $controllerIds = ArrayHelper::getValue($module, 'controllers', []);

                if ($moduleId === null) {
                    throw new InvalidConfigException('The "name" property must be set.');
                }

                if (is_array($controllerIds)) {
                    foreach ($controllerIds as $controllerId => $methodIds) {

                        if (!is_array($methodIds) || $methodIds == []) {
                            $methodIds = $this->defaultMethodIds;
                        }

                        $role = implode($this->separator, array_diff(
                            [
                                $this->normalizeString($this->prefix),
                                $this->normalizeString($moduleId),
                                $this->normalizeString($controllerId),
                            ],
                            ['']
                        ));

                        $permissions = [];
                        foreach ($this->normalizeMethodIds($methodIds) as $method) {
                            $permissions[] = implode($this->separator, array_diff(
                                [
                                    $role,
                                    $this->normalizeString($method),
                                ],
                                ['']
                            ));
                        }

                        $modules[] = [
                            'name' => $role,
                            'controllers' => [
                                $controllerId => $permissions,
                            ],
                        ];
                    }
                }
            }
        }

        $this->modules = $modules;
    }

    /**
     * @return int
     */
    private function installRules()
    {
        foreach ($this->rules as $rule) {
            /** @var Rule $object */
            $object = Yii::createObject($rule);

            if ($this->rbac->getRule($object->name) === null) {
                $this->rbac->add($object);
            }
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * @return int
     * @throws InvalidConfigException
     */
    private function installItems()
    {
        if (is_array($this->modules)) {
            foreach ($this->modules as $module) {

                $roleId = ArrayHelper::getValue($module, 'name');
                $controllersIds = ArrayHelper::getValue($module, 'controllers', []);

                if ($roleId === null) {
                    throw new InvalidConfigException('The "name" property must be set.');
                }

                /**
                 * Добавляем role
                 */
                if (($roleObject = $this->rbac->getRole($roleId)) === null) {
                    $roleObject = $this->rbac->createRole($roleId);
                    $roleObject->description = 'Role:' . $roleId;
                    $this->rbac->add($roleObject);
                }

                if (is_array($controllersIds)) {
                    foreach ($controllersIds as $controllersId => $permissionIds) {
                        if (is_array($permissionIds)) {
                            foreach ($permissionIds as $permissionId) {

                                /**
                                 * Добавляем permission
                                 */
                                if ($this->rbac->getPermission($permissionId) === null) {
                                    $permissionObject = $this->rbac->createPermission($permissionId);
                                    $permissionObject->description = 'Permission:' . $permissionId;
                                    $this->rbac->add($permissionObject);

                                    $this->rbac->addChild($roleObject, $permissionObject);
                                }
                            }

                            /**
                             * Удаляем permission
                             */
                            $permissions = $this->rbac->getPermissionsByRole($roleId);
                            $removePermissions = array_diff(array_keys($permissions), $permissionIds);

                            if (is_array($removePermissions)) {
                                foreach ($removePermissions as $removePermission) {
                                    $this->rbac->remove($permissions[$removePermission]);
                                }
                            }
                        }
                    }
                }

                if (is_array($this->login)) {
                    $userIds = $this->getUserIds($this->login);
                    foreach ($userIds as $userId) {

                        /**
                         * Добавляем role пользователю
                         */
                        if ($this->rbac->getAssignment($roleId, $userId->getId()) === null) {
                            $this->rbac->assign($roleObject, $userId->getId());
                        }
                    }
                }
            }

            /**
             * Удаляем role и ее children
             */
            $roles = $this->rbac->getRoles();
            $removeRoles = array_diff(array_keys($roles), ArrayHelper::getColumn($this->modules, 'name'),
                $this->protectedRoles);

            if (is_array($removeRoles)) {
                foreach ($removeRoles as $removeRole) {
                    $removeChildren = $this->rbac->getChildren($removeRole);
                    if (is_array($removeChildren)) {
                        foreach ($removeChildren as $item) {
                            $this->rbac->remove($item);
                        }
                    }
                    $this->rbac->remove($roles[$removeRole]);
                }
            }
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * @param array $login
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    private function getUserIds(array $login)
    {
        $user = ($this->user);

        return $user::find()->where(['IN', 'login', $login])->all();
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function normalizeString($string)
    {
        return trim($string, $this->separator);
    }

    /**
     * @param array $methodIds
     *
     * @return array
     */
    private function normalizeMethodIds(array $methodIds)
    {
        return array_map(
            function ($row) {
                return $this->normalizeString($row);
            },
            $methodIds
        );
    }
}
