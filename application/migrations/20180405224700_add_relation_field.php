<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_relation_field extends CI_Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `groups` 
                ADD `relation` ENUM('man','women') NULL DEFAULT NULL  
                COMMENT '男方女方' 
                AFTER `name`, ADD INDEX (`relation`);";
        $this->db->query($sql);

        $this->db->query("UPDATE `groups` SET relation = 'man' WHERE name like '%男方%'");
        $this->db->query("UPDATE `groups` SET relation = 'women' WHERE name like '%女方%'");
    }

    public function down()
    {
        $this->dbforge->drop_column('groups', "relation");
    }
}