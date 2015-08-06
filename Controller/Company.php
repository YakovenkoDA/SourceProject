<?php
class Controller_Company extends System_Controller
{
    /**
     * empty
     */
    public function indexAction()
            {
       
            }
    /**
     * load view portfolio
     */        
    public function portfolioAction()
            {
        
            }
     /**
     * load view about us
     */
     public function aboutAction()
             {
        
             }
     /**
     * view contact
     *read xml and set view 
     */        
     public function contactAction()
     {
         /**          
          * @var SimpleXMLElement $configXML
          */
        $configXML = System_Registry::get('configXML');

        $address = (string)$configXML->contact->address;
        $tel     = (string)$configXML->contact->tel;  
        $email   = (string)$configXML->contact->email;
        /**
         * set view
         */
        $this->view->setParam('address', $address);
        $this->view->setParam('tel', $tel);
        $this->view->setParam('email', $email);
    }
}