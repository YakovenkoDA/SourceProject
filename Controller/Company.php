<?php
class Controller_Company extends System_Controller
{
    public function indexAction()
            {
       
            }
    public function portfolioAction()
            {
        
            }
     public function aboutAction()
             {
        
             }
     public function contactAction()
     {
        $configXML = System_Registry::get('configXML');

        $address = (string)$configXML->contact->address;
        $tel     = (string)$configXML->contact->tel;  
        $email   = (string)$configXML->contact->email;
        
        $this->view->setParam('address', $address);
        $this->view->setParam('tel', $tel);
        $this->view->setParam('email', $email);
    }
}