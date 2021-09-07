<?php

namespace app\models;

use DateTime;
use Github\Client;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "accounts".
 *
 * @property int    $id       ID
 * @property string $username Username
 *
 * @property Repo[] $repos
 */
class Account extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'accounts';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
        ];
    }
    
    /**
     * Gets query for [[Repos]].
     *
     * @return ActiveQuery
     */
    public function getRepos(): ActiveQuery
    {
        return $this->hasMany(Repo::class, ['acc_id' => 'id']);
    }
    
    /**
     * Adds repositories from Github
     *
     * @throws Exception
     */
    public function addRepos()
    {
        $client = new Client();
        
        $toUpdate = [];
        
        $repositories = $client->api('user')->repositories($this->username);
        foreach ($repositories as $repository) {
            $updated = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $repository['updated_at']);
            $toUpdate[] = [$this->id, $repository['name'], $updated->format('Y-m-d H:i:s')];
        }
    
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Repo::deleteAll(['acc_id' => $this->id]);
            Yii::$app->db->createCommand()->batchInsert(
                Repo::tableName(),
                ['acc_id', 'repo_name', 'last_update'],
                $toUpdate
            )->execute();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
