<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teachingplan`.
 */
class m191007_144640_create_teachingplan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } 

        $this->createTable('teachingplan', [
            'id' => $this->primaryKey(),
            'userid' => $this->integer()->notNull(),
            'filename' => $this->string()->notNull(),
            'description' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('teachingplan');
    }
}
