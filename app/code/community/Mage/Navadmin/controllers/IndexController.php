<?php
class Mage_Navadmin_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/navadmin?id=15 
    	 *  or
    	 * http://site.com/navadmin/id/15 	
    	 */
    	/* 
		$navadmin_id = $this->getRequest()->getParam('id');

  		if($navadmin_id != null && $navadmin_id != '')	{
			$navadmin = Mage::getModel('navadmin/navadmin')->load($navadmin_id)->getData();
		} else {
			$navadmin = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($navadmin == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$navadminTable = $resource->getTableName('navadmin');
			
			$select = $read->select()
			   ->from($navadminTable,array('navadmin_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$navadmin = $read->fetchRow($select);
		}
		Mage::register('navadmin', $navadmin);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}