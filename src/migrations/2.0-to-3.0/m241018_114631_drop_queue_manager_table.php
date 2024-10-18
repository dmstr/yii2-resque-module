<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%queue_manager}}`.
 */
class m241018_114631_drop_queue_manager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableName = '{{%queue_manager}}';
        // Check if the table exists before dropping
        if ($this->db->schema->getTableSchema($tableName, true) !== null) {
            $this->dropTable($tableName);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m241018_114631_drop_queue_manager_table cannot be reverted.\n";
        return false;
    }
}
