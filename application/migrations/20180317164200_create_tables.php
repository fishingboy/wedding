<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_tables extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array (
            'id' =>
                array (
                    'type' => 'INT',
                    'null' => false,
                    'auto_increment' => true,
                ),
            'name' =>
                array (
                    'type' => 'varchar',
                    'null' => false,
                    'constraint' => '100',
                    'comment' => '姓名',
                ),
            'email' =>
                array (
                    'type' => 'varchar',
                    'null' => true,
                    'constraint' => '255',
                    'comment' => 'email',
                ),
            'phone' =>
                array (
                    'type' => 'varchar',
                    'null' => true,
                    'constraint' => '20',
                    'comment' => '手機',
                ),
            'postal_code' =>
                array (
                    'type' => 'varchar',
                    'null' => true,
                    'constraint' => '10',
                    'comment' => '郵遞區號',
                ),
            'address' =>
                array (
                    'type' => 'varchar',
                    'null' => true,
                    'constraint' => '255',
                    'comment' => '地址',
                ),
            'group_id' =>
                array (
                    'type' => 'int',
                    'null' => true,
                    'comment' => '分類編號',
                ),
            'peoples' =>
                array (
                    'type' => 'int',
                    'null' => true,
                    'comment' => '人數',
                ),
            'vegan_peoples' =>
                array (
                    'type' => 'int',
                    'null' => true,
                    'comment' => '素食人數',
                ),
            'created_at' =>
                array (
                    'type' => 'datetime',
                    'null' => false,
                ),
            'updated_at' =>
                array (
                    'type' => 'datetime',
                    'null' => false,
                ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('group_id', FALSE);
        $this->dbforge->create_table('guests');

        $this->dbforge->add_field(array (
            'id' =>
                array (
                    'type' => 'INT',
                    'null' => false,
                    'auto_increment' => true,
                ),
            'name' =>
                array (
                    'type' => 'varchar',
                    'null' => false,
                    'constraint' => '100',
                    'comment' => '群組名稱',
                ),
            'created_at' =>
                array (
                    'type' => 'datetime',
                    'null' => false,
                ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('groups');
    }

    public function down()
    {
        $this->dbforge->drop_table('guests', TRUE);
        $this->dbforge->drop_table('groups', TRUE);    }
}