<?php
class RoleModel extends Db{
    public function getRoleList(){
        $sql=parent::$connection->prepare('SELECT * FROM `role`');
        return parent::select($sql);
    }
    public function getRoleName($userId)
    {
        $sql=parent::$connection->prepare('SELECT `role_name` FROM `role` INNER JOIN `users` ON `role`.`role_id` = `users`.`user_role` WHERE `users`.`user_id`=?');
        $sql->bind_param('i',$userId);
        return parent::select($sql)[0];
    }
}