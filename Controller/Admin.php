<?php

class Controller_Admin extends System_Controller
{
    /**
     * 
     * @throws Exception
     */
    public function __construct() {
        parent::__construct();
        $userRole = $this->getSessParam('userRole');
        if($userRole != Model_User::ROLE_ADMIN_ID) {            
        throw new Exception('404 error. Page Not Found');    
        }  
    }
    /**
     * 
     */
    public function indexAction()
    {
        
    }
    /**
     * 
     */
    public function customerAction()
    {
     $params = $this->_getArguments();
        
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
      
        $this->view->setParam('customers', $customerModels);
        $this->view->setParam('countCustomers', $countCustomers);
        $this->view->setParam('currentPage', $currentPage);        
    }
    /**
     * 
     */
    public function productAction()
    {       
      $params = $this->_getArguments();
      
        if(!empty($params['limit'])){$this->setSessParam('limit',$params['limit']);}
        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
        if(!empty($params['orderby'])){$this->setSessParam('orderByProduct',$params['orderby']);}
        else {$params['orderby']=$this->getSessParam('orderByProduct',$params['orderby']);}
        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 
        /**
         * @var Model_Product[] $productModels
         */
        if(!empty($params['remove'])){ Model_Product :: remove($params['id']);}
        if(!empty($params['set'])){ $error=Model_Product :: setProduct($params['id']);}
        if(!empty($error)){header('location: '.URL.'/admin/productInfo/page/'.$currentPage.'/error/'.$error.'/id/'.$params['id']);}
        
        $productModels = Model_Product :: getItems($params);              
        $countProducts = Model_Product :: getCountItems();
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
        
        $this->view->setParam('products', $productModels);
        $this->view->setParam('countProducts', $countProducts);        
        $this->view->setParam('currentPage', $currentPage);        
    }
    /**
     * 
     */
    public function productInfoAction()
    {
        $params = $this->_getArguments();
        $currentPage    = !empty($params['page']) ? $params['page'] : 1;
        $this->view->setParam('currentPage', $currentPage);
        if(!empty($params['error'])){$this->view->setParam('error',$params['error']);}
        if(!empty($params['id']))
        {
            $productId = $params['id'];
            
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
     * 
     */
    public function removeAction()
    {
     $params = $this->_getArguments();
         
     $currentPage    = !empty($params['page']) ? $params['page'] : 1;
     $this->view->setParam('currentPage', $currentPage);
     $this->view->setParam('id',$params['id']); 
     $this->view->setParam('action',$params['action']);  
    }
}
