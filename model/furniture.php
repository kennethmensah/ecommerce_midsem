<?php
error_reporting(E_ERROR | E_PARSE);
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/24/16
 * Time: 12:21 AM
 */

require_once 'adb_object.php';

class furniture extends adb_object{

    /**
     * furniture constructor.
     */
    function __construct()
    {
        parent:: __construct();
    }

    /**
     * *********************************************************
     * INSERT QUERIES
     * *********************************************************
     */

    /**
     * @param $type
     * @param $name
     * @param $description
     * @param $category
     * @param $image
     * @return bool|mysqli_stmt
     */
    function addFurniture($type, $name, $description, $category, $brand,$image){

        //sql query
        $str_query = "INSERT INTO furniture(furniture_type, name, description, brand_id, category, image)
                      VALUES (?, ?, ?, ?,?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("issiis", $type, $name, $description, $brand,$category, $image);


        $stmt->execute();

        return $stmt;
    }

    /**
     * Add inventory details
     *
     * @param $fid
     * @param $onhand
     * @param $cost
     * @return bool|mysqli_stmt
     */
    function addInventoryDetails($fid, $onhand, $cost){

        //sql query
        $str_query = "INSERT INTO inventory(furniture_id, onhand, cost, date_added)
                      VALUES (?, ?, ?, ?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $date = date("Y-m-d h:i:s");

        $stmt->bind_param("iids", $fid, $onhand, $cost, $date);


        $stmt->execute();

        return $stmt;
    }


    function updateFurniture($type, $name, $description, $category, $brand,$image, $fid){
        //sql query
        $str_query = "UPDATE furniture
                        SET furniture_type ?,
                        name = ? ,
                        description = ?,
                        brand_id = ?,
                        category = ?,
                        image = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("issiisi", $type, $name, $description, $brand,$category, $image, $fid);

        $stmt->execute();

        return $stmt;
    }


    function updateInventory($fid, $onhand, $cost){
        //sql query
        $str_query = "UPDATE
                      inventory
                      SET
                      onhand = ?,
                      cost = ? ,
                      date_added = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $date = date("Y-m-d h:i:s");

        $stmt->bind_param("iids", $fid, $onhand, $cost, $date);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $type
     * @return bool|mysqli_stmt
     */
    function addFurnitureType($type){

        //sql query
        $str_query = "INSERT INTO furniture_type(furniture_type) VALUES (?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $type);


        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $cat
     * @return bool|mysqli_stmt
     */
    function addCategory($cat){

        //sql query
        $str_query = "INSERT INTO categories(category) VALUES (?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $cat);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $name
     * @return bool|mysqli_stmt
     */
    function addBrand($name){

        //sql query
        $str_query = "INSERT INTO brands(brand_name) VALUES (?)";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("s", $name);

        $stmt->execute();

        return $stmt;
    }


    /**
     * *********************************************************
     * UPDATE QUERIES
     * *********************************************************
     */

    /**
     * @param $fid
     * @param $image
     * @return bool|mysqli_stmt
     */
    function updateImage($fid, $image){
        //sql query
        $str_query = "UPDATE furniture
                      SET
                      image = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("si", $image, $fid);


        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $cost
     * @return bool|mysqli_stmt
     */
    function updateCost($fid, $cost){
        //sql query
        $str_query = "UPDATE inventory
                      SET
                      cost = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("di", $cost, $fid);


        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $fid
     * @return bool|mysqli_stmt
     */
    function updateDate($fid){

        //sql query
        $str_query = "UPDATE inventory
                      SET
                      date_added = ?
                      WHERE furniture_id = ?";

        $date = date("Y-m-d h:i:s");

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("si", $date, $fid);


        $stmt->execute();

        return $stmt;
    }


    /**
     * @param $fid
     * @param $qty
     * @return bool|mysqli_stmt
     */
    function updateQuantity($fid, $qty){

        //sql query
        $str_query = "UPDATE inventory
                      SET
                      onhand = ?
                      WHERE furniture_id = ?";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("ii", $qty, $fid);


        $stmt->execute();

        return $stmt;
    }


    /**
     * *********************************************************
     * SELECT QUERIES
     * *********************************************************
     */

    /**
     * @param $fid
     * @return bool|mysqli_result
     */
    function getProduct($fid){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.furniture_id = ?
                      ORDER BY F.name";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $fid);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $limit
     * @return bool|mysqli_result
     */
    function viewStock($limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      ORDER BY F.name";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @return bool|mysqli_result
     */
    function getStockCount(){
        //sql query
        $str_query = "SELECT COUNT(*) AS totalCount FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      ORDER BY F.brand_id";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $brand
     * @param $limit
     * @return bool|mysqli_result
     */
    function viewByBrandName($brand, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND B.brand_id = ?
                      ORDER BY F.brand_id
                      ";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $brand);

        $stmt->execute();

        return $stmt->get_result();
    }

    function getByBrandCount($brand){
        //sql query
        $str_query = "SELECT COUNT(*) AS totalCount FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND B.brand_id = ?
                      ORDER BY F.brand_id
                      ";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $brand);

        $stmt->execute();

        return $stmt->get_result();
    }


    function viewByCategory($cat, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND C.category_id = ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $cat);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $cat
     * @return bool|mysqli_result
     */
    function getByCatCount($cat){
        //sql query
        $str_query = "SELECT COUNT(*) AS totalCount FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND C.category_id = ?
                      ORDER BY F.brand_id";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $cat);

        $stmt->execute();

        return $stmt->get_result();
    }


    function viewByType($type, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND FT.furniture_type_id = ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->bind_param("i", $type);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @return bool|mysqli_result
     */
    function getCategories(){
        //sql query
        $str_query = "SELECT * FROM categories";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @return bool|mysqli_result
     */
    function getBrands(){

        //sql query
        $str_query = "SELECT * FROM brands";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @return bool|mysqli_result
     */
    function getTypes(){

        //sql query
        $str_query = "SELECT * FROM furniture_type";

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * ***************************************************
     * SEARCH QUERIES
     * ***************************************************
     */

    /**
     * @param $brand
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByBrandName($brand, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND B.brand_name LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $brand = "%{$brand}%";

        $stmt->bind_param("s", $brand);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $cat
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByCategory($cat, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND C.category LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $cat = "%{$cat}%";

        $stmt->bind_param("s", $cat);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $type
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByType($type, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND FT.furniture_type LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $type = "%{$type}%";

        $stmt->bind_param("s", $type);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $name
     * @param $limit
     * @return bool|mysqli_result
     */
    function searchByName($name, $limit){
        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.name LIKE ?
                      ORDER BY F.brand_id";

        $str_query .= " ". $limit;

        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $name = "%{$name}%";

        $stmt->bind_param("s", $name);

        $stmt->execute();

        return $stmt->get_result();
    }


    /**
     * @param $name
     * @return bool|mysqli_result
     */
    function getSearchCount($name){
        //sql query
        $str_query = "SELECT COUNT(*) AS totalCount FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.name LIKE ?
                      ORDER BY F.brand_id";


        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $name = "%{$name}%";

        $stmt->bind_param("s", $name);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $stbrand
     * @param $stname
     * @param $stcat
     * @return bool|mysqli_result
     */
    function getAdvancedSearchCount($stbrand, $stname, $stcat){

        //sql query
        $str_query = "SELECT COUNT(*) AS totalCount FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.name LIKE ?
                      AND B.brand_name LIKE ?
                      AND C.category LIKE ?
                      ORDER BY F.brand_id";


        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stname = "%{$stname}%";
        $stbrand = "%{$stbrand}%";
        $stcat = "%{$stcat}%";

        $stmt->bind_param("sss", $stname, $stbrand, $stcat);

        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $stbrand
     * @param $stname
     * @param $stcat
     * @return bool|mysqli_result
     */
    function advancedSearch($stbrand, $stname, $stcat){

        //sql query
        $str_query = "SELECT * FROM furniture F
                      INNER JOIN inventory I
                      ON F.furniture_id = I.furniture_id
                      INNER JOIN furniture_type FT
                      ON FT.furniture_type_id = F.furniture_type
                      INNER JOIN categories C
                      ON C.category_id = F.category
                      INNER JOIN brands B
                      ON B.brand_id = F.brand_id
                      AND F.name LIKE ?
                      AND B.brand_name LIKE ?
                      AND C.category LIKE ?
                      ORDER BY F.brand_id";


        $stmt = $this->prepareQuery($str_query);

        if($stmt === false){
            return false;
        }

        $stname = "%{$stname}%";
        $stbrand = "%{$stbrand}%";
        $stcat = "%{$stcat}%";

        $stmt->bind_param("sss", $stname, $stbrand, $stcat);

        $stmt->execute();

        return $stmt->get_result();
    }

}


//$testObj = new furniture();
//
//$result = $testObj->viewByCategory('Kitchen', 'LIMIT 8');
//
//$row = $result->fetch_assoc();
//
//var_dump($row);


