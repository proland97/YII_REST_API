<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "messages".
 *
 * @property int $message_id
 * @property string|null $message
 * @property int|null $created_by
 * @property int|null $belongs_to_group
 * @property string|null $create_time
 *
 * @property Groups $belongsToGroup
 * @property Users $createdBy
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['created_by', 'belongs_to_group'], 'default', 'value' => null],
            [['created_by', 'belongs_to_group'], 'integer'],
            [['create_time'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['belongs_to_group'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['belongs_to_group' => 'group_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function extraFields()
    {
        return ['user'];
    }
/*
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => false,
            ]
        ];
    }
*/
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'message' => 'Message',
            'created_by' => 'Created By',
            'belongs_to_group' => 'Belongs To Group',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * Gets query for [[BelongsToGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBelongsToGroup()
    {
        return $this->hasOne(Group::className(), ['group_id' => 'belongs_to_group']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public static function find()
    {
        return new MessagesQuery(get_called_class());
    }
}
