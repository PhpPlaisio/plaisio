<?php
//----------------------------------------------------------------------------------------------------------------------
/**
 * Class ButtonControlTest
 */
class ComplexControlTest extends PHPUnit_Framework_TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test find FormControl by name.
   */
  public function testFindFormControlByName()
  {
    $form = $this->setForm1();

    // Find form control by name. Must return object.
    $control = $form->findFormControlByName( 'street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    // Find form control by name what does not exist. Must return null.
    $control = $form->findFormControlByName( 'not_exists' );
    $this->assertEquals( null, $control );

    $control = $form->findFormControlByName( '/no_path/not_exists' );
    $this->assertEquals( null, $control );

    $control = $form->findFormControlByName( '/vacation/not_exists' );
    $this->assertEquals( null, $control );

  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test find FormControl by path.
   */
  public function testFindFormControlByPath()
  {
    $form = $this->setForm1();

    // Find form control by path. Must return object.
    $control = $form->findFormControlByPath( '/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->findFormControlByPath( '/post/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->findFormControlByPath( '/post/zip-code' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->findFormControlByPath( '/vacation/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->findFormControlByPath( '/vacation/post/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->findFormControlByPath( '/vacation/post/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );


    // Find form control by path what does not exist. Must return null.
    $control = $form->findFormControlByPath( '/not_exists' );
    $this->assertEquals( null, $control );

    $control = $form->findFormControlByPath( '/no_path/not_exists' );
    $this->assertEquals( null, $control );

    $control = $form->findFormControlByPath( '/vacation/not_exists' );
    $this->assertEquals( null, $control );

  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test get FormControl by name.
   */
  public function testGetFormControlByName()
  {
    $form = $this->setForm1();

    // Get form control by name. Must return object.
    $control = $form->getFormControlByName( 'vacation' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $control->getFormControlByName( 'city2' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );
    $this->assertEquals( 'city2', $control->getLocalName() );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test get FormControl by path.
   */
  public function testGetFormControlByPath()
  {
    $form = $this->setForm1();

    // Get form control by path. Must return object.
    $control = $form->getFormControlByPath( '/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->getFormControlByPath( '/post/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->getFormControlByPath( '/vacation/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->getFormControlByPath( '/vacation/post/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );

    $control = $form->getFormControlByPath( '/vacation/post/street' );
    $this->assertInstanceOf( '\SetBased\Html\Form\Control\Control', $control );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by name what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByName1()
  {
    $form = $this->setForm1();
    $form->getFormControlByName( 'not_exists' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by name what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByName2()
  {
    $form = $this->setForm1();
    $form->getFormControlByName( '/no_path/not_exists' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by name what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByName3()
  {
    $form = $this->setForm1();
    $form->getFormControlByName( '/vacation/not_exists' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by path what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByPath1()
  {
    $form = $this->setForm1();
    $form->getFormControlByPath( '/not_exists' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by path what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByPath2()
  {
    $form = $this->setForm1();
    $form->getFormControlByPath( 'street' );
  }


  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by path what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByPath3()
  {
    $form = $this->setForm1();
    $form->getFormControlByPath( '/no_path/not_exists' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Get form control by path what does not exist. Must trow exception.
   *
   * @expectedException Exception
   */
  public function testGetNotExistsFormControlByPath4()
  {
    $form = $this->setForm1();
    $form->getFormControlByPath( '/vacation/not_exists' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Setups a form with a select form control.
   */
  private function setForm1()
  {
    $form     = new SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $complex  = $fieldset->createFormControl( 'complex', '' );
    $complex->createFormControl( 'text', 'street' );
    $complex->createFormControl( 'text', 'city' );

    $complex = $fieldset->createFormControl( 'complex', 'post' );
    $complex->createFormControl( 'text', 'street' );
    $complex->createFormControl( 'text', 'city' );

    $complex = $fieldset->createFormControl( 'complex', 'post' );
    $complex->createFormControl( 'text', 'zip-code' );
    $complex->createFormControl( 'text', 'state' );

    $fieldset = $form->createFieldSet( 'fieldset', 'vacation' );
    $complex  = $fieldset->createFormControl( 'complex', '' );
    $complex->createFormControl( 'text', 'street' );
    $complex->createFormControl( 'text', 'city' );

    $complex = $fieldset->createFormControl( 'complex', 'post' );
    $complex->createFormControl( 'text', 'street' );
    $complex->createFormControl( 'text', 'city' );

    $complex2 = $complex->createFormControl( 'complex', '' );
    $complex2->createFormControl( 'text', 'street2' );
    $complex2->createFormControl( 'text', 'city2' );

    return $form;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
