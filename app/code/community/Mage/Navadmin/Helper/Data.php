<?php

class Mage_Navadmin_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getSelectcat(){
		$model  = Mage::getModel('navadmin/tree');
		$aux[0]['value'] = 0;
		$aux[0]['label'] = 'Root';
		$out = $this->drawSelect(0, $aux);
		return $out;
	}

	public function drawSelect($pid=0, $outini=null, $sep=1){
		$out = array();
		if(!empty($outini)){
			$out = $outini;
		}

		$spacer = '';
		for ($i = 0; $i <= $sep; $i++){
			$spacer.= '&nbsp;&nbsp;&nbsp;';
		}

		$items = $this->getChildrens($pid);
		if(count($items) > 0 ){
			foreach ($items as $item){
				$aux['value'] = $item['navadmin_id'];
				$aux['label'] = $spacer.$item['title'];
				$out[] = $aux;
				$child = $this->getChildrens($item['navadmin_id']);
				if(!empty($child)){
					$out = $this->drawSelect($item['navadmin_id'], $out, $sep + 1);
				}
			}
		}
		return $out;
	}

	public function getChildrens($pid=0){
		$out = array();
        $collection = Mage::getModel('navadmin/navadmin')->getCollection()
        	->addFieldToFilter('pid', array('in'=>$pid) )
			->addFieldToFilter('status', array('in'=>'1') )
			->setOrder('position', 'asc');

		foreach ($collection as $item){
			$out[] = $item->getData();
		}
		return $out;
	}

	public function hasChildrens($pid=0){
        $collection = Mage::getModel('navadmin/navadmin')->getCollection()
        	->addFieldToFilter('pid', array('in'=>$pid) )
			->addFieldToFilter('status', array('in'=>'1') )
			->setOrder('position', 'asc')
			->load();
		if($collection->count() > 0){
			return true;
		}
		return false;
	}


    public function drawItem($pid=0, $level=0)
    {
        $html = '';
        $items = $this->getChildrens($pid);
        if (!empty($childrens)) {
            return $html;
        }
		$i = 0;
		$totreg = count($items);
        foreach ($items as $k => $item){
	        $html.= '<li';
	        $hasChildrens = $this->hasChildrens($item['navadmin_id']);
	        if ($hasChildrens) {
	             $html.= ' onmouseover="toggleMenu(this,1)" onmouseout="toggleMenu(this,0)"';
	        }

	        $html.= ' class="level'.$level;
	        $html.= ' nav-'.str_replace('/', '-', $item['link']);
	        if ($i == 0){
	        	$html .= ' first';
	        }elseif ($totreg == ($k + 1)){
	        	$html .= ' last';
	        }

	        if ($hasChildrens) {
	            $html .= ' parent';
	        }
	        $html.= '">'."\n";
	        if($item['target'] == '_blank'){
	        	$html.= '<a href="http://'.$item['link'].'"  target="_blank">';
	        }else{
	        	$html.= '<a href="'.$item['link'].'">';
	        }
	        $html.= '<span>'.$this->htmlEscape($item['title']).'</span></a>'."\n";

	        if ($hasChildrens){
	            $htmlChildren = '';
                $htmlChildren.= $this->drawItem($item['navadmin_id'], $level+1);
	            if (!empty($htmlChildren)) {
	                $html.= '<ul class="level' . $level . '">'."\n"
	                        .$htmlChildren
	                        .'</ul>';
	            }
	        }
	        $html.= '</li>'."\n";
	        $i++;
        }
        return $html;
    }
}