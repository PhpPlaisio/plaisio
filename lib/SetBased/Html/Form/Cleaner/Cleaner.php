<?php
//----------------------------------------------------------------------------------------------------------------------
/**
 * @author Paul Water
 * @par    Copyright:
 * Set Based IT Consultancy
 * $Date: 2013/03/04 19:02:37 $
 * $Revision:  $
 */
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Html\Form\Cleaner;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Interface Cleaner
 * Interface for defining classes for cleaning submitted values and translated formatted values to machine values.
 *
 * @package SetBased\Html\Form\Cleaner
 */
interface Cleaner
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the cleaned value of @a $theValue.
   *
   * @param mixed $theValue
   */
  public function clean( $theValue );
}

//----------------------------------------------------------------------------------------------------------------------
