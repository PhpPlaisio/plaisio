<?php
//----------------------------------------------------------------------------------------------------------------------
use SetBased\Html\Form;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Class CheckboxesControlTest Test class for testing SatBased\Html\Form\CheckboxesControl class.
 */
class CheckboxesControlTest extends PHPUnit_Framework_TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   *  Option with index 0 (string or int) equals 0 (string or int) and not equals 0.0 (string or float).
   */
  public function testEmptyValues1()
  {
    $_POST['cnt_id']['0'] = 'on';

    $form   = $this->setupForm3();
    $values = $form->getValues();

    // Test checkbox with index '0' has been checked.
    $this->assertTrue( $values['cnt_id']['0'] );

    // Test checkbox with index '0.0' has not been checked.
    $this->assertFalse( $values['cnt_id']['0.0'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   *  Option with index 0 (string or int) equals 0 (string or int) and not equals '0.0' (string).
   */
  public function testEmptyValues2()
  {
    $_POST['cnt_id'][0] = 'on';

    $form   = $this->setupForm3();
    $values = $form->getValues();

    // Test checkbox with index '0' has been checked.
    $this->assertTrue( $values['cnt_id']['0'] );

    // Test checkbox with index '0.0' has not been checked.
    $this->assertFalse( $values['cnt_id']['0.0'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   *  Option with index '0.0' (string) equals '0.0' (string) and not equals 0 (string or int).
   */
  public function testEmptyValues3()
  {
    $_POST['cnt_id']['0.0'] = 'on';

    $form   = $this->setupForm3();
    $values = $form->getValues();

    // Test checkbox with index '0' has not been checked.
    $this->assertFalse( $values['cnt_id']['0'] );

    // Test checkbox with index '0.0' has been checked.
    $this->assertTrue( $values['cnt_id']['0.0'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   *  Option with index 0 (string or int) equals 0 (string or int) and not equals '1' (string).
   */
  public function testEmptyValues4()
  {
    $_POST['cnt_id']['0'] = 'on';

    $form   = $this->setupForm4();
    $values = $form->getValues();

    // Test checkbox with index '0' has been checked.
    $this->assertTrue( $values['cnt_id']['0'] );

    // Test checkbox with index '1' has not been checked.
    $this->assertFalse( $values['cnt_id']['1'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   *  Option with index 0 (string or int) equals 0 (string or int) and not equals '1' (string).
   */
  public function testEmptyValues5()
  {
    $_POST['cnt_id'][0] = 'on';

    $form   = $this->setupForm4();
    $values = $form->getValues();

    // Test checkbox with index '0' has been checked.
    $this->assertTrue( $values['cnt_id']['0'] );

    // Test checkbox with index '0.0' has not been checked.
    $this->assertFalse( $values['cnt_id']['1'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test checkboxes are set of unset when was submitted.
   */
  public function testPreserveSubmitValues()
  {
    // Simulate submitted values.
    $_POST['cnt_id'] = array('0' => 'on', '2' => 'on', '3' => 'on');

    $countries[] = array('cnt_id' => 0, 'cnt_name' => 'NL');
    $countries[] = array('cnt_id' => 1, 'cnt_name' => 'BE');
    $countries[] = array('cnt_id' => 2, 'cnt_name' => 'LU');
    $countries[] = array('cnt_id' => 3, 'cnt_name' => 'DE');
    $countries[] = array('cnt_id' => 4, 'cnt_name' => 'GB');

    // Create a form with checkboxes.
    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'checkboxes', 'cnt_id' );
    $control->setAttribute( 'set_options', $countries );
    $control->setAttribute( 'set_map_key', 'cnt_id' );
    $control->setAttribute( 'set_map_label', 'cnt_name' );

    $form->LoadSubmittedValues();

    // Generate HTML code for the form.
    $form = $form->Generate();

    $doc = new DOMDocument();
    $doc->loadXML( $form );
    $xpath = new DOMXpath($doc);

    // Asset that the checkboxes are set or unset according to the $values.
    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[0]' and @type='checkbox' and @checked='checked']" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[1]' and @type='checkbox' and not(@checked)]" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[2]' and @type='checkbox' and @checked='checked']" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[3]' and @type='checkbox' and @checked='checked']" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[4]' and @type='checkbox' and not(@checked)]" );
    $this->assertEquals( 1, $list->length );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test checkboxes are set of unset correctly with setValues().
   */
  public function testSetValues2()
  {
    $countries[] = array('cnt_id' => 0, 'cnt_name' => 'NL', 'checked' => true);
    $countries[] = array('cnt_id' => 1, 'cnt_name' => 'BE', 'checked' => true);
    $countries[] = array('cnt_id' => 2, 'cnt_name' => 'LU');
    $countries[] = array('cnt_id' => 3, 'cnt_name' => 'DE');
    $countries[] = array('cnt_id' => 4, 'cnt_name' => 'GB');

    // Create a form with checkboxes.
    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'checkboxes', 'cnt_id' );
    $control->setAttribute( 'set_options', $countries );
    $control->setAttribute( 'set_map_key', 'cnt_id' );
    $control->setAttribute( 'set_map_label', 'cnt_name' );
    $control->setAttribute( 'set_map_checked', 'checked' );

    // Set the values of the checkboxes.
    $values['cnt_id'][0] = true;
    $values['cnt_id'][1] = false;
    $values['cnt_id'][2] = true;
    $values['cnt_id'][3] = true;
    $values['cnt_id'][4] = false;

    $form->setValues( $values );

    // Generate HTML code for the form.
    $form = $form->Generate();

    $doc = new DOMDocument();
    $doc->loadXML( $form );
    $xpath = new DOMXpath($doc);

    // Asset that the checkboxes are set or unset according to the $values.
    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[0]' and @type='checkbox' and @checked='checked']" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[1]' and @type='checkbox' and not(@checked)]" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[2]' and @type='checkbox' and @checked='checked']" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[3]' and @type='checkbox' and @checked='checked']" );
    $this->assertEquals( 1, $list->length );

    $list = $xpath->query( "/form/fieldset/div/input[@name='cnt_id[4]' and @type='checkbox' and not(@checked)]" );
    $this->assertEquals( 1, $list->length );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test a check/unchecked checkboxes are added correctly to the values.
   */
  public function testSubmittedValues1()
  {
    $_POST['cnt_id']['2'] = 'on';

    $form   = $this->setupForm1();
    $values = $form->getValues();

    // Test checkbox with index 3 has been checked.
    $this->assertTrue( $values['cnt_id']['2'] );

    // Test checkbox with index 1 has not been checked.
    $this->assertFalse( $values['cnt_id']['1'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test a check/unchecked checkboxes are added correctly to the values.
   */
  public function testSubmittedValues2()
  {
    $_POST['cnt_id']['0.1'] = 'on';

    $form   = $this->setupForm1();
    $values = $form->getValues();

    // Test checkbox with index 3 has been checked.
    $this->assertTrue( $values['cnt_id']['0.1'] );

    // Test checkbox with index 1 has not been checked.
    $this->assertFalse( $values['cnt_id']['1'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test a check/unchecked checkboxes are added correctly to the values.
   */
  public function testSubmittedValues3()
  {
    $_POST['cnt_id']['2'] = 'on';

    $form   = $this->setupForm2();
    $values = $form->getValues();

    // Test checkbox with index 2 has been checked.
    $this->assertTrue( $values['cnt_id']['2'] );

    // Test checkbox with index 1 has not been checked.
    $this->assertFalse( $values['cnt_id']['1'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test a check/unchecked checkboxes are added correctly to the values.
   */
  public function testSubmittedValues4()
  {
    $_POST['cnt_id']['0.1'] = 'on';

    $form   = $this->setupForm2();
    $values = $form->getValues();

    // Test checkbox with index 3 has been checked.
    $this->assertTrue( $values['cnt_id']['0.1'] );

    // Test checkbox with index 1 has not been checked.
    $this->assertFalse( $values['cnt_id']['1'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Only white listed values must be loaded.
   */
  public function testWhiteListed1()
  {
    // cnt_id is not a value that is in the white list of values (i.e. 1,2, and 3).
    $_POST['cnt_id']['99'] = 'on';

    $form    = $this->setupForm1();
    $values  = $form->getValues();
    $changed = $form->getChangedControls();

    $this->assertArrayNotHasKey( 'cnt_id', $changed );
    $this->assertArrayNotHasKey( '99', $values['cnt_id'] );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Setups a form with a select form control.
   */
  private function setupForm1()
  {
    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'checkboxes', 'cnt_id' );

    $countries[] = array('cnt_id' => '0', 'cnt_name' => '-');
    $countries[] = array('cnt_id' => '1', 'cnt_name' => 'NL');
    $countries[] = array('cnt_id' => '2', 'cnt_name' => 'BE');
    $countries[] = array('cnt_id' => '3', 'cnt_name' => 'LU');
    $countries[] = array('cnt_id' => '0.1', 'cnt_name' => 'UA');

    $control->setAttribute( 'set_map_key', 'cnt_id' );
    $control->setAttribute( 'set_options', $countries );

    $form->loadSubmittedValues();

    return $form;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Setups a form with a select form control. Difference between this function
   * and SetupForm1 are the cnt_id are numbers.
   */
  private function setupForm2()
  {
    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'checkboxes', 'cnt_id' );

    $countries[] = array('cnt_id' => 0, 'cnt_name' => 'NL');
    $countries[] = array('cnt_id' => 1, 'cnt_name' => 'BE');
    $countries[] = array('cnt_id' => 2, 'cnt_name' => 'LU');
    $countries[] = array('cnt_id' => 0.1, 'cnt_name' => 'UA');

    $control->setAttribute( 'set_map_key', 'cnt_id' );
    $control->setAttribute( 'set_options', $countries );
    $control->setAttribute( 'set_map_checked', '2' );

    $form->loadSubmittedValues();

    return $form;
  }

  //-------------------------------------------------------------------------------------------------------------------
  /**
   * Setups a form with a select form control.
   */
  private function setupForm3()
  {
    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'checkboxes', 'cnt_id' );

    $countries[] = array('cnt_id' => '0', 'cnt_name' => 'NL');
    $countries[] = array('cnt_id' => '0.0', 'cnt_name' => 'BE');

    $control->setAttribute( 'set_map_key', 'cnt_id' );
    $control->setAttribute( 'set_options', $countries );

    $form->loadSubmittedValues();

    return $form;
  }

  //-------------------------------------------------------------------------------------------------------------------
  /**
   * Setups a form with a select form control.
   */
  private function setupForm4()
  {
    $form     = new \SetBased\Html\Form();
    $fieldset = $form->createFieldSet();
    $control  = $fieldset->createFormControl( 'checkboxes', 'cnt_id' );

    $countries[] = array('cnt_id' => 0, 'cnt_name' => 'NL');
    $countries[] = array('cnt_id' => 1, 'cnt_name' => 'BE');

    $control->setAttribute( 'set_map_key', 'cnt_id' );
    $control->setAttribute( 'set_options', $countries );

    $form->loadSubmittedValues();

    return $form;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
