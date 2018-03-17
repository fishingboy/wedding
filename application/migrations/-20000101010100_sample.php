<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Sample extends CI_Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `tests` (
                     `id` INT NOT NULL AUTO_INCREMENT ,
                     `main_clicker_evaluation_id` INT NOT NULL COMMENT '互評主題的編號' ,
                     `clicker_evaluation_id` INT NOT NULL COMMENT '互評編號' ,
                     `low_description` VARCHAR(50) NOT NULL COMMENT '下限的描述' ,
                     `middle_description` VARCHAR(50) NOT NULL COMMENT '中位數的描述' ,
                     `high_description` VARCHAR(50) NOT NULL COMMENT '上限的描述' ,
                     PRIMARY KEY (`id`),
                     INDEX (`main_clicker_evaluation_id`),
                     INDEX (`clicker_evaluation_id`))
                     ENGINE = InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT = '同儕互評的成績描述';";
        $this->db->query($sql);

    }

    public function down()
    {
        $this->db->query("DROP TABLE `tests`");
    }
}