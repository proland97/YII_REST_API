<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property int $group_id
 * @property string|null $group_name
 * @property string|null $create_time
 *
 * @property Messages[] $messages
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time'], 'safe'],
            [['group_name'], 'string', 'max' => 255],
        ];
    }

    public function extraFields()
    {
        return ['messages'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'group_name' => 'Group Name',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['belongs_to_group' => 'group_id']);
    }
}
