<?php
//----------------------------------------------------------------------------------------------------------------------
/** @author Paul Water
 *
 * @par Copyright:
 * Set Based IT Consultancy
 *
 * $Date: 2013/03/04 19:02:37 $
 *
 * $Revision:  $
 */
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Html\Form;

//----------------------------------------------------------------------------------------------------------------------
/** @brief Class for form controls of type file.
 */
class FileControl extends SimpleControl
{
  //--------------------------------------------------------------------------------------------------------------------
  public function setAttribute( $theName, $theValue, $theExtendedFlag=false )
  {
    switch ($theName)
    {
      // Basic attributes.
    // case 'name':
    // case 'type':
    case 'value':

      // Advanced attributes.
    case 'accept':
    case 'accesskey':
    case 'disabled':
    case 'ismap':
    case 'onblur':
    case 'onchange':
    case 'onfocus':
    case 'onselect':
    case 'readonly':
    case 'tabindex':

      // Common core attributes.
    case 'class':
    case 'id':
    case 'title':

      // Common internationalization attributes.
    case 'xml:lang':
    case 'dir':

      // Common event attributes.
    case 'onclick':
    case 'ondblclick':
    case 'onmousedown':
    case 'onmouseup':
    case 'onmouseover':
    case 'onmousemove':
    case 'onmouseout':
    case 'onkeypress':
    case 'onkeydown':
    case 'onkeyup':

      // Common style attribute.
    case 'style':

      // H2O Attributes
    case 'set_prefix':
    case 'set_postfix':
    case 'set_clean':

      $this->setAttributeBase( $theName, $theValue );
      break;

    default:
      if ($theExtendedFlag)
      {
        $this->setAttributeBase( $theName, $theValue );
      }
      else
      {
        SetBased\Html\Html::error( "Unsupported attribute '%s'.", $theName );
      }
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function generate( $theParentName  )
  {
    $ret  = (isset($this->myAttributes['set_prefix'])) ? $this->myAttributes['set_prefix'] : '';
    $ret .= $this->generatePrefixLabel();
    $ret .= '<input';

    $ret .= SetBased\Html\Html::generateAttribute( 'type', 'file' );

    foreach( $this->myAttributes as $name => $value )
    {
      switch ($name)
      {
      case 'name':
        $submit_name = $this->getSubmitName( $theParentName );
        $ret .= SetBased\Html\Html::generateAttribute( $name, $submit_name );
        break;

      default:
        $ret .= SetBased\Html\Html::generateAttribute( $name, $value );
      }
    }

    $ret .= '/>';
    $ret .= $this->generatePostfixLabel();
    if (isset($this->myAttributes['set_postfix'])) $ret .= $this->myAttributes['set_postfix'];

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  protected function loadSubmittedValuesBase( &$theSubmittedValue, &$theWhiteListValue, &$theChangedInputs )
  {
    $obfuscator  = (isset($this->myAttributes['set_obfuscator'])) ? $this->myAttributes['set_obfuscator'] : null;
    $local_name  = $this->myAttributes['name'];
    $submit_name = ($obfuscator) ? $obfuscator->encode( $local_name ) : $local_name;

    if ($_FILES[$submit_name]['error']===0)
    {
      $theChangedInputs[$local_name]  = true;
      $theWhiteListValue[$local_name] = $_FILES[$submit_name];
      $this->myAttributes['value']    = $_FILES[$submit_name];
    }
    else
    {
      $theWhiteListValue[$local_name] = false;
    }

    // Set the submitted value to be used method GetSubmittedValue.
    $this->myAttributes['set_submitted_value'] = $theWhiteListValue;
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function setValuesBase( &$theValues )
  {
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
