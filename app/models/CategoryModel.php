<?php
class CategoryModel extends Db
{
    public function getCategoryList(){
        $sql = parent::$connection->prepare("SELECT * FROM category");
        return parent::select($sql);
    }
    public function getCategoryListPage($perPage,$page)
    {
        $start = ($page - 1) * $perPage;
        // Bước 2: Tạo câu query
        $sql = parent::$connection->prepare("SELECT * FROM category LIMIT $start, $perPage");
        return parent::select($sql);
    }
    // Lấy tổng danh mục
    public function getTotalCate()
    {
        $sql = parent::$connection->prepare("SELECT COUNT(category_id) FROM category");
        return parent::select($sql)[0]['COUNT(category_id)'];
    }
    // Lấy danh mục sp theo id
    public function getCategoryById($catId)
    {
        $sql=parent::$connection->prepare('SELECT * FROM category WHERE category_id=?');
        $sql->bind_param('i',$catId);
        return parent::select($sql)[0];
    }
    // Thêm danh mục sản phẩm
    public function addCategory($catName)
    {
        $sql = parent::$connection->prepare('INSERT INTO `category` (`category_name`) VALUES (?)');
        $sql->bind_param('s', $catName);
        return $sql->execute();
    }
    // Cập nhật danh mục sản phẩm
    public function updateCategory($catName, $catId)
    {
        $sql = parent::$connection->prepare('UPDATE `category` SET `category_name` = ? WHERE `category`.`category_id` = ?');
        $sql->bind_param('si', $catName, $catId);
        return $sql->execute();
    }
    // // Xóa danh mục sản phẩm theo id
    public function deleteCategoryById($catId)
    {
        $sql = parent::$connection->prepare('DELETE FROM `category` WHERE `category`.`category_id` = ?');
        $sql->bind_param('i', $catId);
        return $sql->execute();
    }
     // Lấy danh mục sp của product có id = 
     public function getCategoryByProductId($productId){
        $sql=parent::$connection->prepare('SELECT * FROM `category` 
        INNER JOIN `product_category_brand` ON category.category_id=product_category_brand.category_id
        WHERE product_category_brand.product_id =?');
        $sql->bind_param('i',$productId);
        return parent::select($sql)[0];
     }
     
     public function addCatBrand($catId,$brandId){
        $sql = parent::$connection->prepare('INSERT INTO `brand_category` (`category_id`,`brand_id`) VALUES (?,?)');
        $sql->bind_param('is', $catId,$brandId);
        return $sql->execute();
     }
     public function getMaxId(){
        $sql = parent::$connection->prepare('SELECT MAX(category_id) FROM `category`');
        return parent::select($sql)[0];
     }
     public function getBrandByCat($catId){
        $sql = parent::$connection->prepare('SELECT * FROM `brand_category`  WHERE `brand_category`.category_id = ?');
        $sql->bind_param('i', $catId);
        return parent::select($sql)[0];
     }
    
     public function updateCatBrand($catId,$brandId){
        $sql = parent::$connection->prepare('UPDATE `brand_category` SET 
        `brand_id` = ? WHERE `brand_category`.`category_id` = ?');
         $sql->bind_param('si',$brandId,$catId);
         return $sql->execute();
     }
     // Xóa dữ liệu của bảng brand_cat khi có catid = ?
     public function deleteBrandCat($catId){
        $sql = parent::$connection->prepare('DELETE FROM `brand_category` WHERE `brand_category`.`category_id` = ?');
        $sql->bind_param('i', $catId);
        return $sql->execute();
     }
     // Hàm kiếm category theo keyword
     public function searchCat($keyword)
     {
        $search = "%{$keyword}%";
        $sql = parent::$connection->prepare("SELECT * FROM category  WHERE category_name LIKE ?");
        $sql->bind_param('s', $search);
        return parent::select($sql);   
     }
}
