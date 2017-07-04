<?php

use yii\db\Migration;

class m161005_124320_uploads extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('uploads', [
            'id' => $this->primaryKey(),
            'attribute' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'mime_type' => $this->string(),
            'size' => $this->integer(),
            'original_name' => $this->string(),
            'params' => $this->text(),
            'name' => $this->string(),
            'hash' => $this->string(40),
            'extension' => $this->string(),
            'type' => $this->smallInteger(3),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'uploads_linked',
            'uploads',
            ['model', 'parent_id', 'attribute']
        );
        $this->createIndex(
            'uploads_hash',
            'uploads',
            'hash'
        );
        $this->createIndex(
            'uploads_name',
            'uploads',
            'name'
        );
    }

    public function down()
    {
        $this->dropIndex(
            'uploads_linked',
            'uploads'
        );

        $this->dropIndex(
            'uploads_hash',
            'uploads'
        );

        $this->dropIndex(
            'uploads_name',
            'uploads'
        );

        $this->dropTable('uploads');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
