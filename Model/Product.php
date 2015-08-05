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
    
    
    public function getDiscountPrice()
    {
        return $this->price * 0.8;
    }
    
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
    
    public static function getCountItems()
    {
        $dbTableProduct = new Model_Db_Table_Product();
        $countItems     = $dbTableProduct->getCount();
        return $countItems; 
    }
    public static function remove($id)
    {
     $dbTableProduct = new Model_Db_Table_Product();
     $dbTableProduct->removeByID($id);
    }
    public static function setProduct($id=NULL)
    {
    if(!empty($_POST['name']))
    {       
    $id   = trim($id);
    $name = trim($_POST['name']);
    
    $dbTableProduct = new Model_Db_Table_Product();
    $resalt=$dbTableProduct->selectByName($name,$id);
    if($resalt != NULL){return $error=1;}
    }
    else
        {
        throw new Exception('incorect name', System_Exception::VALIDATE_ERROR);
        }
    $modelProduct = new self();    
    $modelProduct->id           = $id;
    $modelProduct->name         = $name;   
    $modelProduct->price        = !empty($_POST['price']) ? trim($_POST['price']) : 0;
    $modelProduct->total        = !empty($_POST['total']) ? trim($_POST['total']) : 0;
    $modelProduct->description  = !empty($_POST['description']) ? $_POST['description'] : ' ';
    $modelProduct->img          = !empty($_FILES['img']['name']) ? $_FILES['img']['name'] : ' ';
    
    $dbTableProduct->create($modelProduct);
    
    if(!empty($_FILES['img']['name']))
        {         
        $pathImg= SITE_PATH.'img/Products/'.$_FILES['img']['name'];
        if($_FILES['img']['error']==0 && !file_exists($pathImg))
            {            
            move_uploaded_file($_FILES['img']['tmp_name'],$pathImg);                 
            }
        else 
            {
            unset($_FILES);
            throw new Exception('Can not upload file', System_Exception::VALIDATE_ERROR);
            }    
        }      
    }
}