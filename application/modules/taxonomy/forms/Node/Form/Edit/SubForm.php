<?php

class Taxonomy_Form_Node_Form_Edit_SubForm extends EPIC_Form_SubForm
{
    
    public function init()
    {
        $this->setLegend('Taxonomy settings')
             ->setOrder(40);
             
        $type = $this->getAttrib('type');
        $vocabularies = Taxonomy_Model_Vocabulary::getVocabulariesByNodetypeId($type->id);
        
        if (!empty($vocabularies)) {
            
            foreach ($vocabularies as $vocabulary) {
                if ($vocabulary->tags) {
                    $element = new Zend_Form_Element_Text($vocabulary->name);
                    $filter = new EPIC_Filter_Tags();
                    $element->addFilter($filter);
                }
                elseif ($vocabulary->multiple) {
                    $element = new Zend_Form_Element_MultiSelect($vocabulary->name);
                }
                else {
                    $element = new Zend_Form_Element_Select($vocabulary->name);
                    $element->addMultiOption(NULL, '');
                }

                $element->setLabel($vocabulary->name)
                        ->setDescription($vocabulary->help)
                        ->setRequired($vocabulary->required);

                if (!$vocabulary->tags) {
                    $terms = $vocabulary->getTerms();

                    foreach ($terms as $term) {
                        $element->addMultiOption($term->id, $term->name);
                    }
                }
                
                $this->addElement($element);
            }
        }
    }
    
    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);

        $node = $this->getAttrib('node');
        $type = $this->getAttrib('type');
        $vocabularies = Taxonomy_Model_Vocabulary::getVocabulariesByNodetypeId($type->id);
        
        $termIds = array();

        foreach ($node->Terms as $term) {
            $termIds[] = $term->id;
        }

        // Populate each vocabulary element.
        foreach ($vocabularies as $vocabulary) {
            $element = $this->getElement($vocabulary->name);

            if ($vocabulary->tags) {
                $values = array();
                foreach ($node->Terms as $term) {
                    foreach ($vocabulary->Terms as $vTerm) {
                        if ($vTerm->name == $term->name) {
                            $values[] = $term->name;
                            break;
                        }
                    }
                }
                $element->setValue(implode(', ', $values));
            }
            else {
                $element->setValue($termIds);
            }
        }
    }
    
    public function process($context = array())
    {
        $node = $context['node'];
        $nodetype = $context['node']->Type;
        $vocabularies = Taxonomy_Model_Vocabulary::getVocabulariesByNodetypeId($nodetype->id);
        
        $node->unlink('Terms');
        $node->save();
        
        foreach ($vocabularies as $vocabulary) {
            if ($vocabulary->tags) {
                $tags = explode(',', $this->getValue($vocabulary->name));
                foreach ($tags as $tag) {
                    $exists = FALSE;
                    foreach ($vocabulary->Terms as $term) {
                        if ($term->name == $tag) {
                            $exists = TRUE;
                            break;
                        }
                    }
                    if (!$exists) {
                        // Create the new term.
                        $term = new Taxonomy_Model_Term();
                        $term->name = $tag;
                        $term->Vocabulary = $vocabulary;
                        $term->save();
                    }
                    $node->Terms[] = $term;
                }
            }
            else {
                $termIds = $this->getValue($vocabulary->name);
                
                if (count($termIds)) {
                    $node->link('Terms', $termIds);
                }
            }
        }
        
        $node->save();
    }
}
