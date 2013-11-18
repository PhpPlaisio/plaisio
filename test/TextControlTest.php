<?php
//----------------------------------------------------------------------------------------------------------------------
class TextControlTest extends SimpleControlTest
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cleaning is done before testing value of the form control has changed.
   */
  public function testPruneWhitespaceNoChanged()
  {
    $_POST['test'] = '  Hello    World!   ';

    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'text', 'test' );
    $control->setAttribute( 'value', 'Hello World!' );

    $form->loadSubmittedValues();

    $values  = $form->getValues();
    $changed = $form->getChangedControls();

    $this->assertEquals( 'Hello World!', $values['test'] );

    //$this->assertFalse( $changed['test'] );

  }

  //--------------------------------------------------------------------------------------------------------------------
  protected function getInputType()
  {
    return 'text';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
