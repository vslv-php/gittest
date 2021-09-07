<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accounts}}`.
 */
class m210907_064125_create_accounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accounts}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'username' => $this->string()->notNull()->comment('User name'),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%accounts}}');
    }
}
