<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once (__DIR__ . "/Seeder_base.php");

/**
 * 分類
 */
class Group_seeder extends Seeder_base
{
    public function run()
    {
        $this->CI->db->truncate("groups");
        $this->CI->load->model("groups_model");

        $groups = [
            ["name" => "男方同學"],
            ["name" => "男方同事"],
            ["name" => "男方朋友"],
            ["name" => "男方親威"],

            ["name" => "女方同學"],
            ["name" => "女方同事"],
            ["name" => "女方朋友"],
            ["name" => "女方親威"],
        ];

        $n = 0;
        foreach ($groups as $group) {
            $this->CI->groups_model->create($group);
            $n++;
        }
        return $n;
    }
}