<?php 

class EPIC_Form_BareDisplayGroup extends Zend_Form_DisplayGroup
{

    /**
     * Element label
     * @var string
     */
    protected $_label;

    /**
     * Initialize the DisplayGroup.
     */
    public function init()
    {
        $this->clearDecorators();
        $this->addDecorators(array('FormElements', 'Errors', 'Description'))
             ->addDecorator('HtmlTag', array('tag' => 'dd', 'id' => $this->getName() . '-element'))
             ->addDecorator('Label', array('tag' => 'dt'));
    }
    
    /**
     * Override addElement to change the decorators each
     * element uses.
     *
     * @param Zend_Form_Element $element
     */
    public function addElement(Zend_Form_Element $element)
    {
        $element->setDecorators(array('ViewHelper'));
        parent::addElement($element);
    }
    
    /**
     * Set element label
     *
     * @param  string $label
     * @return Zend_Form_Element
     */
    public function setLabel($label)
    {
        $this->_label = (string) $label;
        return $this;
    }

    /**
     * Retrieve element label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Is the element required?
     * (required by the "Label" decorator)
     *
     * @return bool
     */
    public function isRequired()
    {
    	foreach ($this->getElements() as $element) {
    		if ($element->isRequired()) {
    			return TRUE;
    		}
    	}
        return FALSE;
    }

    /**
     * Render display group
     * 
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
        if (null !== $view) {
            $this->setView($view);
        }
        $content = '';
        $firstElement = current($this->getElements());
        foreach ($this->getDecorators() as $decorator) {
        	// We want a Label decorator to identify with our first form element.
        	if ($firstElement && (!is_a($firstElement, 'Zend_Form_Element_Submit')) && (get_class($decorator) == 'Zend_Form_Decorator_Label')) {
        		$decorator->setId($firstElement->getId());
        	}
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }
        return $content;
    }

    
    /**
     * Retrieve error messages
     *
     * @return array
     */
    public function getMessages()
    {
    	$messages = array();
    	foreach ($this->getElements() as $element) {
    		foreach ($element->getMessages() as $key => $val) {
    			$messages[$element->getName()."-$key"] = $val;
    		}
    	}
    	return $messages;
    }
}
