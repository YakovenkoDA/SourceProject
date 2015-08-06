<?php
class Controller_User extends System_Controller
{
    /**
     * empty
     */
    public function indexAction()
    {
        
    }        
    /**
     * User profile view
     */
    public function profileAction()
    {
        $args = $this->_getArguments();

        $userId = $args['id'];
        /**
         * @var Model_User $modelUser
         */
        try {
            $modelUser = Model_User :: getById($userId);
            $this->view->setParam('user', $modelUser);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }        
}