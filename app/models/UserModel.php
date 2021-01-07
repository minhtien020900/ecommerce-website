<?php
class UserModel extends Db
{
   // Lấy ds để phân trang
   public function getUserListPage($perPage, $page)
    {
        $start = ($page - 1) * $perPage;
        // Bước 2: Tạo câu query
        $sql = parent::$connection->prepare("SELECT * FROM users LIMIT $start, $perPage");
        return parent::select($sql);
    }
    // Lấy tổng admin ( có role != 1)
    public function getTotalUser()
    {
        $sql = parent::$connection->prepare("SELECT COUNT(user_id) FROM users WHERE `user_role` = 2");
        return parent::select($sql)[0]['COUNT(user_id)'];
    }
    // Thêm user
    public function addUser($name,$email,$phone,$pass,$image,$role,$date_create,$date_update,$status)
    {
        $sql=parent::$connection->prepare('INSERT INTO `users` ( `user_name`, `user_email`, `user_phone`,`user_pass`,`user_image`,`user_role`,`user_date_create`,`user_last_update`,`user_status`) VALUES ( ?, ?, ? ,?,?,?,?,?,?);');
      $sql->bind_param('sssssissi',$name,$email,$phone,$pass,$image,$role,$date_create,$date_update,$status);
      return $sql->execute();
    }

    // Lấy ds admin
   public function getAllUser()
   {
      $sql=parent::$connection->prepare('SELECT * FROM `users`');
      return parent::select($sql);
   }
   // Lấy tt admin có id
   public function getUserby($id)
   {
      $sql=parent::$connection->prepare('SELECT * FROM `users` where `user_id` = ?');
      $sql->bind_param('i',$id);
      return parent::select($sql)[0];
   }
   // Cập nhật admin theo id
   public function updateUser($id,$name,$email,$phone,$image,$role,$date_create,$date_update,$status)
   {
      $sql = parent::$connection->prepare('UPDATE `users` SET 
         `user_name` = ?, `user_email`=?, `user_phone`=?,`user_image`=?,`user_role`=?,`user_date_create`=?,`user_last_update`=?,`user_status`=? WHERE `users`.`user_id` = ?');
          $sql->bind_param('ssssissii',$name,$email,$phone,$image,$role,$date_create,$date_update,$status,$id);
          return $sql->execute();
   }
   // Lấy ds admin có role = ?
   public function getUserbyRole($roleId)
   {
      $sql=parent::$connection->prepare('SELECT * FROM `users` INNER JOIN `role` ON `users`.`user_role` = `role`.`role_id` WHERE `role`.`role_id` = ?');
      $sql->bind_param('i',$roleId);
      return parent::select($sql);
   }
   // Xóa user có id =?
   public function deleteUserById($id){
      $sql = parent::$connection->prepare('DELETE FROM `users` WHERE `users`.`user_id` = ?');
      $sql ->bind_param('i',$id);
      return $sql->execute();
   }
   // Update pass
   public function updatePass($id,$newPass,$update)
   {
      $sql = parent::$connection->prepare('UPDATE `users` SET 
         `user_pass` = ?,`user_last_update` = ? WHERE `users`.`user_id` = ?');
          $sql->bind_param('ssi',$newPass,$update,$id);
          return $sql->execute();
   }
   // Tìm user theo keyword
   public function searchUser($keyword)
     {
        $search = "%{$keyword}%";
        $sql = parent::$connection->prepare("SELECT * FROM users  WHERE user_email LIKE ? and user_role=2");
        $sql->bind_param('s', $search);
        return parent::select($sql);   
     }

   // Cập nhật Profile
   public function updateProfile($id,$name,$image,$date_update)
   {
      $sql = parent::$connection->prepare('UPDATE `users` SET 
         `user_name` = ?,`user_image`=?,`user_last_update`=? WHERE `users`.`user_id` = ?');
          $sql->bind_param('sssi',$name,$image,$date_update,$id);
          return $sql->execute();
   }
   public function updateCustomer($id,$name)
   {
      $sql = parent::$connection->prepare('UPDATE `users` SET 
         `user_name` = ? WHERE `users`.`user_id` = ?');
          $sql->bind_param('si',$name,$id);
          return $sql->execute();
   }
}
