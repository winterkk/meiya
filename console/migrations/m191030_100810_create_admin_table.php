<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin}}`.
 */
class m191030_100810_create_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->notNull()->comment('用户'),
            'password' => $this->string(32)->notNull()->comment('密码'),
            'phone' => $this->string(15)->notNull()->defaultValue(0)->comment('手机'),
            'email' => $this->string(64)->notNull()->comment('邮箱'),
            'avatar' => $this->text()->comment('头像'),
            'reg_at' => $this->datetime(),
            'reg_ip' => $this->string(20)->comment('注册IP'),
            'state' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('0删除1正常2禁用'),
            'login_at' => $this->datetime()->notNull(),
            'login_ip' => $this->datetime(),
        ]);

        //create index for column `username`
        $this->createIndex(
            'idx-admin-username',
            '{{%admin}}',
            'username'
        );
        $this->createIndex(
            'idx-admin-phone',
            '{{%admin}}',
            'phone'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-admin-username',
            '{{%admin}}'
        );
        $this->dropIndex(
            'idx-admin-phone',
            '{{%admin}}'
        );
        $this->dropTable('{{%admin}}');
    }
}
