<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repos}}`.
 */
class m210907_064214_create_repos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repos}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'acc_id' => $this->integer()->notNull()->comment('User ID'),
            'repo_name' => $this->string()->notNull()->comment('Repository'),
            'last_update' => $this->dateTime()->notNull()->comment('Last update'),
        ]);
        
        $this->addForeignKey(
            'fk-repo_account',
            '{{%repos}}',
            'acc_id',
            '{{%accounts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%repos}}');
    }
}
