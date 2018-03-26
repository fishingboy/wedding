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
            ["name" => "男方大學同學"],
            ["name" => "男方高中同學"],
            ["name" => "男方國中國小同學"],
            ["name" => "男方台灣數位同事"],
            ["name" => "男方 ASAP 同事"],
            ["name" => "男方學悅同事"],

            ["name" => "女方大學同學"],
            ["name" => "女方高中同事"],
            ["name" => "女方慧訊同事"],
            ["name" => "女方愛合購同事"],
        ];

        $n = 0;
        foreach ($groups as $group) {
            $this->CI->groups_model->create($group);
            $n++;
        }
        return $n;
    }
}