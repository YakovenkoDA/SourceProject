<?php
class Controller_Product extends System_Controller
{
 
    public function indexAction()
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
        $productModels = Model_Product :: getItems($params);
        $countProducts = Model_Product :: getCountItems();
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
        
        $this->view->setParam('products', $productModels);
        $this->view->setParam('countProducts', $countProducts);        
        $this->view->setParam('currentPage', $currentPage);        
    }  
}
