<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _initLayoutHelper(){
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		
		
	}

        protected function  _initDoctype(){

            $this->bootstrap("view");
            $view = $this->getResource("view");
            $view->doctype("XHTML1_STRICT");
        }        
        

     protected function _initTranslation(){
     	 // We use the Swedish locale as an example
		  $locale = "de";
		  Zend_Registry::set('Zend_Locale', $locale);
		
		  // Create Session block and save the locale
		  $session = new Zend_Session_Namespace('languages');
		  $langLocale = isset($session->lang) ? $session->lang : $locale;
		       
		  // Set up and load the translations (all of them!)
		  $translate = new Zend_Translate(
		    array(		
		        'adapter' => 'array',
		        'content' => APPLICATION_PATH . '/languages/en/index_en.php',
		        'locale'  => 'en'		        
		    ));
		  //$translate->addTranslate(array("content"=>APPLICATION_PATH."/languages/index_en.php","locale"=>"en"));		
		  $translate->setLocale($langLocale); // Use this if you only want to load the translation matching current locale, experiment.
		       
		  // Save it for later
		  $registry = Zend_Registry::getInstance();
		  $registry->set('Zend_Translate', $translate);
     }
	protected function _initNavigation()
	{
		try {
			$this->bootstrap('layout');
		    $layout = $this->getResource('layout');
		    $view = $layout->getView();
		    $config = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml','nav');
		
		    $navigation = new Zend_Navigation($config);
		    $view->navigation($navigation);		    
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	    
	}
}

