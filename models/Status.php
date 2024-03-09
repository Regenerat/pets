<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $status
 *
 * @property Requests[] $Requests
 */
class Status extends \yii\db\ActiveRecord
{
    const NEW_STATUS_ID = 1;
    const CONFIRMED_STATUS_ID = 2;
    const DECLINED_STATUS_ID = 3;
    const FIND_STATUS_ID = 4;
    const NOT_FIND_STATUS_ID = 5;

    public function __toString() {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['status_id' => 'id']);
    }
}
