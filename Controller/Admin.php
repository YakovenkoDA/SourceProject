<?php
class Controller_Admin extends System_Controller
{
    public function __construct() {
        parent::__construct();
        $userRole = $this->getSessParam('userRole');
        if($userRole != Model_User::ROLE_ADMIN_ID) {            
        throw new Exception('404 error. Page Not Found');    
        }  
    }

    public function indexAction()
    {
        
    }
    public function customerAction()
    {
     $params = $this->_getArguments();
        
        if(!empty($params['limit'])){$this->setSessParam('limit',$params['limit']);}
        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
        if(!empty($params['orderby'])){$this->setSessParam('orderby',$params['orderby']);}
        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 
        /**
         * @var Model_User[] $customerModels
         */
        $customerModels = Model_User :: getItems($params);
        $countCustomers = Model_User :: getCountItems();
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
      
        $this->view->setParam('customers', $customerModels);
        $this->view->setParam('countCustomers', $countCustomers);
        $this->view->setParam('limit', $this->getSessParam('limit'));
        $this->view->setParam('currentPage', $currentPage);
        $this->view->setParam('orderType',$this->getSessParam('ordertype'));
        $this->view->setParam('orderBy', $this->getSessParam('orderby'));    
    }
    public function productAction()
    {       
      $params = $this->_getArguments();
        $this->setSessParam('orderby','id');
        if(!empty($params['limit'])){$this->setSessParam('limit',$params['limit']);}
        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
        if(!empty($params['orderby'])){$this->setSessParam('orderby',$params['orderby']);}
        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 
        /**
         * @var Model_Product[] $productModels
         */
        if(!empty($params['remove'])){ Model_Product :: remove($params['id']);}
        if(!empty($params['set'])){ Model_Product :: setProduct($params['id']);}
        $productModels = Model_Product :: getItems($params);              
        $countProducts = Model_Product :: getCountItems();
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
        
        $this->view->setParam('products', $productModels);
        $this->view->setParam('countProducts', $countProducts);
        $this->view->setParam('limit', $this->getSessParam('limit'));
        $this->view->setParam('currentPage', $currentPage);
        $this->view->setParam('orderType',$this->getSessParam('ordertype'));
        $this->view->setParam('orderBy', $this->getSessParam('orderby')); 
    }
    public function productInfoAction()
    {
        $params = $this->_getArguments();
        $currentPage    = !empty($params['page']) ? $params['page'] : 1;
        $this->view->setParam('currentPage', $currentPage);
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
}
