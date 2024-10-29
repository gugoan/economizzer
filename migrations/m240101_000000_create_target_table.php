<?php

use yii\db\Migration;

/**
 * Handles the creation of table `target`.
 */
class m240101_000000_create_target_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('target', [
      'id' => $this->primaryKey(),
      'value' => $this->float()->notNull(),
      'description' => $this->string(255)->notNull(),
      'target_date' => $this->date()->notNull(),
      'user_id' => $this->integer()->notNull(),
      'created_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
      'updated_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
    ]);

    // Adiciona a coluna is_completed
    $this->addColumn('target', 'is_completed', $this->boolean()->defaultValue(false));

    // Cria índice e chave estrangeira para user_id
    $this->createIndex('idx-target-user_id', 'target', 'user_id');
    $this->addForeignKey('fk-target-user_id', 'target', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    // Droga a chave estrangeira para user_id
    $this->dropForeignKey('fk-target-user_id', 'target');
    $this->dropIndex('idx-target-user_id', 'target');

    $this->dropColumn('target', 'is_completed');
    $this->dropTable('target');
  }
}
