<?php

namespace backend\maps\admin;

use mdm\admin\components\ItemController;
use yii\rbac\Item;

/**
 * RoleController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class RoleController extends ItemController
{
    public $layout = "@backend/views/layouts/main";

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $view = $this->getView();
            if (isset($view->params['breadcrumbs']) && isset($view->params['breadcrumbs'][0])) {
                $view->params['breadcrumbs'][0] = [
                    'label' => '系统管理',
                ];
            }
            return true;
        }
    }

    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'Item' => 'Role',
            'Items' => 'Roles',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_ROLE;
    }
}
