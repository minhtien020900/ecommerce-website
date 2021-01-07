<?php
class StatusModel extends Db
{
    public function getStatusList(){
        $sql=parent::$connection->prepare('SELECT * FROM `status`');
        return parent::select($sql);
    }
    public function getStatusName($userId)
    {
        $sql=parent::$connection->prepare('SELECT `status_name` FROM `status` INNER JOIN `users` ON `status`.`status_id` = `users`.`user_status` WHERE `users`.`user_id`=?');
        $sql->bind_param('i',$userId);
        return parent::select($sql)[0];
    }
}
