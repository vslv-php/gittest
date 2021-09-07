<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "repos".
 *
 * @property int          $id          ID
 * @property int          $acc_id      User ID
 * @property string       $repo_name   Repository
 * @property string       $last_update Last update
 *
 * @property-read Account $account
 */
class Repo extends ActiveRecord
{
    public const LAST_N = 10;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'repos';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['acc_id', 'repo_name', 'last_update'], 'required'],
            [['acc_id'], 'integer'],
            [['last_update'], 'safe'],
            [['repo_name'], 'string', 'max' => 255],
            [
                ['acc_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Account::class,
                'targetAttribute' => ['acc_id' => 'id']
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'acc_id' => 'User ID',
            'repo_name' => 'Repository',
            'last_update' => 'Last update',
        ];
    }
    
    /**
     * Gets query for [[Account]].
     *
     * @return ActiveQuery
     */
    public function getAccount(): ActiveQuery
    {
        return $this->hasOne(Account::class, ['id' => 'acc_id']);
    }
}
