<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\AuthAssignment]].
 *
 * @see \common\models\AuthAssignment
 */
class AuthAssignmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\AuthAssignment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\AuthAssignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}