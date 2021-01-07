<?php 
class CartModel extends Db  
{
    public function addCart($user_id,$proId,$pro_name,$proQlt,$proPrice,$proImg)
    {
        $sql=parent::$connection->prepare('INSERT INTO `carts` (  `user_id`, `product_id`,`product_name`, `product_quanlity`,`product_price`,`cart_image`) VALUES ( ?, ?, ?,?,?,?);');
        $sql->bind_param('iisids',$user_id,$proId,$pro_name,$proQlt,$proPrice,$proImg);
        return $sql->execute();
    }

    public function getCartByUserProduct($userId,$proId)
    {
      $sql=parent::$connection->prepare('SELECT * FROM `carts` where `user_id`=? AND `product_id`=?');
      $sql->bind_param('ii',$userId,$proId);
      return parent::select($sql);
    }   
    public function getCartByUser($userId)
    {
      $sql=parent::$connection->prepare('SELECT * FROM `carts` where `user_id`= ? order BY cart_id desc');
      $sql->bind_param('i',$userId);
      return parent::select($sql);
    }   
    public function updateCart($user_id,$proId,$proQlt)
    {
      $sql = parent::$connection->prepare('UPDATE `carts` SET `product_quanlity` = ? WHERE `carts`.`user_id` = ? AND `carts`.`product_id` = ?');
      $sql->bind_param('iii', $proQlt,$user_id, $proId);
      return $sql->execute();
    }
    public function DeleteCart($id)
    {
      $sql = parent::$connection->prepare('DELETE FROM `carts` WHERE `carts`.`cart_id` = ?');
      $sql->bind_param('i', $id);
      return $sql->execute();
    }
    public function getCartByCartId($id)
    {
      $sql=parent::$connection->prepare('SELECT * FROM `carts` where `cart_id` =?');
      $sql->bind_param('i',$id);
      return parent::select($sql);
    }
}
