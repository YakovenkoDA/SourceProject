<?php

class Controller_Admin extends System_Controller
{
    /**
     * @throws Exception
     * if user role is not admin
     */
    public function __construct() {
        parent::__construct();
        $userRole = $this->getSessParam('userRole');
        if($userRole != Model_User::ROLE_ADMIN_ID) {            
        throw new Exception('404 error. Page Not Found');    
        }  
    }
    /**
     * load view
     */
    public function indexAction()
    {
        
    }
    /**
     * Admin customer
     * return Model_User to view 
     */
    public function customerAction()
    {
     $params = $this->_getArguments();
        /**
         * check $params 
         */
        if(!empty($params['limit'])){$this->setSessParam('limit',$params['limit']);}
        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
        if(!empty($params['orderby'])){$this->setSessParam('orderByCustomer',$params['orderby']);}
        else {$params['orderby']=$this->getSessParam('orderByCustomer',$params['orderby']);}
        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 
        /**
         * @var Model_User[] $customerModels
         */
        $customerModels = Model_User :: getItems($params);
        $countCustomers = Model_User :: getCountItems();
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
        /**
         * set view
         */
        $this->view->setParam('customers', $customerModels);
        $this->view->setParam('countCustomers', $countCustomers);
        $this->view->setParam('currentPage', $currentPage);        
    }
    /**
     * Admin product
     * return Model_Product to view
     */
    public function productAction()
    {       
      $params = $this->_getArguments();
        /**
         * check $params 
         */
        if(!empty($params['limit'])){$this->setSessParam('limit',$params['limit']);}
        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
        if(!empty($params['orderby'])){$this->setSessParam('orderByProduct',$params['orderby']);}
        else {$params['orderby']=$this->getSessParam('orderByProduct',$params['orderby']);}
        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 
        /**
         * if remove or insert(update) product
         */
        if(!empty($params['remove'])){ Model_Product :: remove($params['id']);}
        if(!empty($params['set'])){ $error = Model_Product :: setProduct($params['id']);}
        if(!empty($error)){header('location: '.URL.'/admin/productInfo/page/'.$currentPage.'/error/'.$error.'/id/'.$params['id']);}
        /**
         * @var Model_Product[] $productModels
         */        
        try {
            $productModels = Model_Product :: getItems($params);              
            $countProducts = Model_Product :: getCountItems();  
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
        /**
         * set view
         */
        $this->view->setParam('products', $productModels);
        $this->view->setParam('countProducts', $countProducts);        
        $this->view->setParam('currentPage', $currentPage);        
    }
    /**
     * product info
     */
    public function productInfoAction()
    {
        $params = $this->_getArguments();
        /**
         * check $params 
         */
        $currentPage    = !empty($params['page']) ? $params['page'] : 1;
        $this->view->setParam('currentPage', $currentPage);
        if(!empty($params['error'])){$this->view->setParam('error',$params['error']);}
        /**
         * set view
         * if update product
         */
        if(!empty($params['id']))
        {
            $productId = $params['id'];
            /**
            * @var Model_Product[] $modelProduct
            */  
            try {
                $modelProduct = Model_Product :: getById($productId);
                $this->view->setParam('product', $modelProduct);
            }
            catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
            }
        }      
    
    }
    /**
     * view  ask if remove
     */
    public function removeAction()
    {
     $params = $this->_getArguments();
     /**
      * set view
      */   
     $currentPage    = !empty($params['page']) ? $params['page'] : 1;
     $this->view->setParam('currentPage', $currentPage);
     $this->view->setParam('id',$params['id']); 
     $this->view->setParam('action',$params['action']);  
    }
}
