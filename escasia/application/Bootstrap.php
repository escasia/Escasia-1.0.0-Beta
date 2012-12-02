<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView()
	{
	    $view = new Zend_View();
	    $view->doctype('XHTML1_STRICT');
	    // do other stuff to the view...
	    return $view;
	}
	
}

