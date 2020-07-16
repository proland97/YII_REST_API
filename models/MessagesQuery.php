<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Message]].
 *
 * @see Message
 */
class MessagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Message[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Message|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function ofId($id){
        return $this->andWhere(['message_id' => $id]);
    }

    public function ofUserId($id){
        return $this->andWhere(['created_by' => $id]);
    }
}
