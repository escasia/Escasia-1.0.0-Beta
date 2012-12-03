<?php
// application/controllers/IndexController.php
 
class CrawlerController extends Zend_Controller_Action
{
 
    public function init()
    {
        /* Initialize action controller here */
    }
 
    public function indexAction()
    {
		$crawlerD = new Application_Model_Crawlers_CrawlerD();
		$crawlerD->execute();
       
    }
}