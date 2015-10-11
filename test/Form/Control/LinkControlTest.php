<?php
//----------------------------------------------------------------------------------------------------------------------
use SetBased\Abc\Form\Form;

//----------------------------------------------------------------------------------------------------------------------
class LinkControlTest extends PHPUnit_Framework_TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  public function testPrefixAndPostfix()
  {
    $form     = new Form();
    $fieldset = $form->createFieldSet();

    $control = $fieldset->createFormControl('a', 'name');

    $control->setPrefix('Hello');
    $control->setPostfix('World');
    $html = $form->Generate();

    $pos = strpos($html, 'Hello<a>');
    $this->assertNotEquals(false, $pos);

    $pos = strpos($html, '</a>World');
    $this->assertNotEquals(false, $pos);
  }

  //--------------------------------------------------------------------------------------------------------------------

}

//----------------------------------------------------------------------------------------------------------------------
