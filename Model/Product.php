<?php
class Model_Product
{
    /**
     *  @var int 
     */
    public $id;
    
    /**
     *
     * @var string  
     */
    public $name;
    
    /**
     *
     * @var string 
     */
    public $description;
    
    /**
     *
     * @var string 
     */
    public $img;
    
    /**
     *
     * @var double 
     */
    public $price;
    
    /**
     *
     * @var int 
     */
    public $total;
    /**
     * 
     * @param type $params
     * @return \self
     */
    public static function getItems($params)
    {
        $dbTableProduct = new Model_Db_Table_Product();
        $productsData   = $dbTableProduct->getByCriteria($params);
        
        $productModels = array();
        
        foreach ($productsData as $item) {
            $productModel               = new self();
            $productModel->id           = $item->id;
            $productModel->name         = $item->name;
            $productModel->description  = $item->description;
            $productModel->img          = $item->img;
            $productModel->price        = $item->price;
            $productModel->total        = $item->total;
            $productModels[] = $productModel;
        }
        
        return $productModels;
    }
    /**
     * 
     * @return \self
     */
    public function getAll()
    {
        $productTable = new Model_Db_Table_Product();
        $products = $productTable->getAll();
        
        
        $productModels = array();
        foreach ($products as $item) {
            $productModel = new self();
            $productModel->id = $item->id;
            $productModel->name = $item->name;
            $productModel->description = $item->description;
            $productModel->price = $item->price;
            $productModel->total = $item->total;
            $productModels[] = $productModel;
        }
             
        return $productModels;
    }
    /**
     * 
     * return DiscountPrice
     */
    
    public function getDiscountPrice()
    {
        return $this->price * 0.8;
    }
    /**
     * 
     * @return type
     */
    public function getProductLink()
    {
        return '<a href="./info/id/' . $this->id .  '">' . $this->name . '</a>';
    }
    
    /**
     * 
     * @param int $productId
     * @return Model_Product
     * @throws Exception
     */
    public static function getById($productId)
    {
        $productTable     =  new Model_Db_Table_Product();

        $productData   =  reset($productTable->getById($productId));
                
        if($productData) {
            $modelProduct  = new self();
            $modelProduct->id           = $productData->id;
            $modelProduct->img          = $productData->img;
            $modelProduct->name         = $productData->name;
            $modelProduct->description  = $productData->description;
            $modelProduct->price        = $productData->price;
            $modelProduct->total        = $productData->total;

            return $modelProduct;
        }
        else {
            throw new Exception('Product not found', System_Exception::NOT_FOUND);
        }
    }
    /**
     * 
     * @return int $countItems
     */
    public static function getCountItems()
    {
        $dbTableProduct = new Model_Db_Table_Product();
        $countItems     = $dbTableProduct->getCount();
        return $countItems; 
    }
    /**
     * if remove product
     * 
     * @param int $id
     */
    public static function remove($id)
    {
        /**
         * @var Model_Db_Table_Product $dbTableProduct
         */
        $dbTableProduct = new Model_Db_Table_Product();
        $dbTableProduct->removeByID($id);
    }
    /**
     * if insert or update product
     * 
     * @param type $id
     * @return type
     */
    public static function setProduct($id=NULL)
    {
        if(!empty($_POST['name']))
        {       
            $id   = trim($id);
            $name = trim($_POST['name']);
            /**
             * @var Model_Db_Table_Producte $dbTableProduct
             */
            $dbTableProduct = new Model_Db_Table_Product();
            $resalt=$dbTableProduct->selectByName($name,$id);
            /**
             *@return $error
             */
            if($resalt != NULL){return $error=1;}
            /**
            *upload file
            *@return $error
            */
            if(!empty($_FILES['img']['name']))
                {
                $pathImg= SITE_PATH.'img/Products/'.$_FILES['img']['name'];
                if($_FILES['img']['error']!=0){return $error=6;}
                if(file_exists($pathImg)){return $error=7;}
                move_uploaded_file($_FILES['img']['tmp_name'],$pathImg);
                }
        }
        /**
         * @return int $error
         */
         else
            {
            return $error=1;
            }
    /**
     * @var Model_Product $modelProduct
     */
    $modelProduct = new self();    
    $modelProduct->id           = $id;
    $modelProduct->name         = $name;   
    $modelProduct->price        = !empty($_POST['price']) ? trim($_POST['price']) : 0;
    $modelProduct->total        = !empty($_POST['total']) ? trim($_POST['total']) : 0;
    $modelProduct->description  = !empty($_POST['description']) ? $_POST['description'] : ' ';
    $modelProduct->img          = !empty($_FILES['img']['name']) ? $_FILES['img']['name'] : ' ';
    
    $dbTableProduct->create($modelProduct);            
    }
}