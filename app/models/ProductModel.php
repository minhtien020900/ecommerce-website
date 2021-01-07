<?php
class ProductModel extends Db
{
   public function getProductList($perPage, $page)
    {
        $start = ($page - 1) * $perPage;
        // Bước 2: Tạo câu query
        $sql = parent::$connection->prepare("SELECT * FROM products LIMIT $start, $perPage");
        return parent::select($sql);
    }
     // Tìm sản phẩm theo keyword
     public function searchProduct($keyword,$perPage, $page)
     {
        $start = ($page - 1) * $perPage;
        $search = "%{$keyword}%";
        $sql = parent::$connection->prepare("SELECT * FROM products  WHERE product_name LIKE ? LIMIT $start, $perPage");
        $sql->bind_param('s', $search);
        return parent::select($sql);   
     }
     public function search($keyword)
     {
        $search = "%{$keyword}%";
        $sql = parent::$connection->prepare("SELECT * FROM products  WHERE product_name LIKE ?");
        $sql->bind_param('s', $search);
        return parent::select($sql);   
     }
    // Lấy tổng sản phảm
    public function getTotalProduct()
    {
        $sql = parent::$connection->prepare("SELECT COUNT(product_id) FROM products");
        return parent::select($sql)[0]['COUNT(product_id)'];
    }
    public function getTotalProductKeyword($keyword)
    {
      $search = "%{$keyword}%";
      $sql = parent::$connection->prepare('SELECT COUNT(product_id) FROM products WHERE product_name LIKE ?');
      $sql->bind_param('s',$search);
      return parent::select($sql)[0]['COUNT(product_id)'];
    }
   // Lấy ds sản phẩm
   public function getAllproduct()
   {
      $sql=parent::$connection->prepare('SELECT * FROM `products`');
      return parent::select($sql);
   }
    // Lấy sp theo Id danh mục và Id thương hiệu
     public function getProductInBrand($catId,$brdId){
        $sql=parent::$connection->prepare('SELECT * FROM `products` INNER JOIN product_category_brand ON  products.`product_id` =  product_category_brand.`product_id`
        WHERE `product_category_brand`.`category_id`=? AND `product_category_brand`.`brand_id`=?');
        $sql->bind_param('ii',$catId,$brdId);
        return parent::select($sql);
     }
     // Lấy sp theo Id
     public function getProductById($productId){
        $sql=parent::$connection->prepare('SELECT * FROM products WHERE product_id=?');
        $sql->bind_param('i',$productId);
        return parent::select($sql)[0];
     }
     // Thêm sản phẩm:
     public function addProduct($proName,$proDesc,$proPrice,$proImg_main,$proType,$proSoluong,$proImg_Other){
      $sql=parent::$connection->prepare('INSERT INTO `products` ( `product_name`, `product_desc`, `product_price`, `product_image`, `product_featured`, `product_soluong`,`product_image_other`) VALUES ( ?, ?, ?, ?, ?, ? ,?);');
      $sql->bind_param('ssdsiis',$proName,$proDesc,$proPrice,$proImg_main,$proType,$proSoluong,$proImg_Other);
      return $sql->execute();
     }
     // Thêm product_category_brand
     public function addProCatBrand($productId,$catId,$brandId){
      $sql=parent::$connection->prepare('INSERT INTO `product_category_brand` (`product_id`,`category_id`, `brand_id`) VALUES ( ?,?, ?)');
      $sql->bind_param('iii',$productId,$catId,$brandId);
      return $sql->execute();
     }
     // Update sản phẩm:
      public function updateProduct($id,$proName,$proDesc,$proPrice,$proImg_main,$proType,$proSoluong,$proImg_Other)
      {
         $sql = parent::$connection->prepare('UPDATE `products` SET 
         `product_name` = ?,`product_desc` = ?,`product_price` = ?,`product_image` = ?,`product_featured` = ?, `product_soluong` = ?,`product_image_other` = ? WHERE `products`.`product_id` = ?');
          $sql->bind_param('ssdsiisi',$proName,$proDesc,$proPrice,$proImg_main,$proType,$proSoluong,$proImg_Other,$id);
          return $sql->execute();
      }

      // Update cate và brand của sp:
      public function updateCateBrand($id,$catId,$brandId){
         $sql = parent::$connection->prepare('UPDATE `product_category_brand` SET 
         `category_id` = ?,`brand_id` = ? WHERE `product_category_brand`.`product_id` = ?');
          $sql->bind_param('iii',$catId,$brandId,$id);
          return $sql->execute();
      }

      // Lấy id max 
      public function getMaxId(){
         $sql = parent::$connection->prepare('SELECT MAX(product_id) FROM `products`');
         return parent::select($sql)[0];
      }
      // Xóa sp theo id
      public function deleteProById($productId){
         $sql = parent::$connection->prepare('DELETE FROM `products` WHERE `products`.`product_id` = ?');
         $sql ->bind_param('i',$productId);
         return $sql->execute();
      }
      // Xóa sp trong bảng pro_cat_brand
      public function deleteProCatBrand($productId){
         $sql = parent::$connection->prepare('DELETE FROM `product_category_brand` WHERE `product_category_brand`.`product_id` = ?');
         $sql->bind_param('i',$productId);
         return $sql->execute();
      }

      public function getProductByFeatrue($product_featured){
         $sql=parent::$connection->prepare('SELECT * FROM products WHERE product_featured=?');
         $sql->bind_param('i',$product_featured);
         return parent::select($sql) ;
      }
      public function getProductByBrandId($brandId){
         $sql=parent::$connection->prepare('SELECT * FROM `products` INNER JOIN product_category_brand ON  products.`product_id` =  product_category_brand.`product_id`
        WHERE `product_category_brand`.`brand_id`=?');
        $sql->bind_param('i',$brandId);
        return parent::select($sql);
      }
   //   public function getCategoryByProductId($productId){
   //    $sql=parent::$connection->prepare('SELECT * FROM `category` 
   //    INNER JOIN `product_category_brand` ON category.category_id=product_category_brand.category_id
   //    WHERE product_category_brand.product_id =?');
   //    $sql->bind_param('i',$productId);
   //    return $sql->execute();
 //  }
}
