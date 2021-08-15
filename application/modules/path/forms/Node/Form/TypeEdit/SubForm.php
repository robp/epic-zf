<?php

class Path_Form_Node_Form_TypeEdit_SubForm extends EPIC_Form_SubForm
{
    
    public function init()
    {
        $this->setLegend('URL path settings')
             ->setOrder(200)
             ->addElement('text', 'route', array(
                    'label' => 'Automatic alias pattern',
             )); 
    }
    
    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);
        $type = Doctrine_Core::getTable('Node_Model_Type')->find($defaults['id']);
        
        if (!empty($type->Path->route)) {
            $this->getElement('route')->setValue($type->Path->route);
        }
    }
    
    public function process($context = array())
    {
        $type = $context['type'];
        $path = $type->Path;
        
        if (isset($path->route)) {
            if ($this->getValue('route')) {
                $path->route = $this->getValue('route');
                $path->save();
            }
            else {
                $path->delete();
            }
        }
        elseif ($this->getValue('route')) {
            $path = new Path_Model_TypeRoute();
            $path->Type = $type;
            $path->route = $this->getValue('route');
            $path->save();
        }
    }
}
