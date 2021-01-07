<?php
class BrandModel extends Db
{

    public function getBrandPage($perPage,$page)
    {  
        $start = ($page - 1) * $perPage;
        // Bước 2: Tạo câu query
        $sql = parent::$connection->prepare("SELECT * FROM brand LIMIT $start, $perPage");
        return parent::select($sql);

    }
     // Lấy tổng thương hiệu
     public function getTotalBrand()
     {
         $sql = parent::$connection->prepare("SELECT COUNT(brand_id) FROM brand");
         return parent::select($sql)[0]['COUNT(brand_id)'];
     }
    public function getBrandList()
    {
        $sql = parent::$connection->prepare('SELECT * FROM brand');
        return parent::select($sql);
    }
    // Lấy thương hiệu sp theo danh mục
    public function getBrandInCategory($brandId)
    {
        $sql=parent::$connection->prepare('SELECT * FROM brand INNER JOIN brand_category ON brand.brand_id = brand_category.brand_id
        WHERE brand_category.category_id=?');
        $sql->bind_param('i',$brandId);
        return parent::select($sql);
    }
    public function getBrandNamebyProductId($productId){
        $sql=parent::$connection->prepare('SELECT * FROM `brand` 
        INNER JOIN `product_category_brand` ON brand.brand_id=product_category_brand.brand_id
        WHERE product_category_brand.product_id = ?');
        $sql->bind_param('i',$productId);
        return parent::select($sql)[0];
    }
    public function getBrandtById($id){
        $sql=parent::$connection->prepare('SELECT * FROM brand WHERE brand_id=?');
        $sql->bind_param('i',$id);
        return parent::select($sql)[0];
     }
     // Thêm thương hiệu
     public function addBrand($brandName,$brandImage)
    {
        $sql = parent::$connection->prepare('INSERT INTO `brand` (`brand_name`,`brand_image`) VALUES (?,?)');
        $sql->bind_param('ss', $brandName,$brandImage);
        return $sql->execute();
    }
    // Cập nhật thương hiệu
    public function updateBrand($brandName,$brandImage, $brandId)
    {
        $sql = parent::$connection->prepare('UPDATE `brand` SET `brand_name` = ? ,`brand_image` = ? WHERE `brand`.`brand_id` = ?');
        $sql->bind_param('ssi', $brandName,$brandImage, $brandId);
        return $sql->execute();
    }
    // xóa thương hiệu
    public function deleleBrand($brandId){
        $sql = parent::$connection->prepare('DELETE FROM `brand` WHERE `brand`.`brand_id` = ?');
        $sql->bind_param('i', $brandId);
        return $sql->execute();
    }
    // tìm thương hiệu theo keyword
    public function searchBrand($keyword)
    {
       $search = "%{$keyword}%";
       $sql = parent::$connection->prepare("SELECT * FROM brand  WHERE brand_name LIKE ?");
       $sql->bind_param('s', $search);
       return parent::select($sql);   
    }

}
