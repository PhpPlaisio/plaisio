<?php
//----------------------------------------------------------------------------------------------------------------------
/** @author Paul Water
 *
 * @par Copyright:
 * Set Based IT Consultancy
 *
 * $Date: 2011/09/14 19:55:10 $
 *
 * $Revision: 1.2 $
 */
//----------------------------------------------------------------------------------------------------------------------
/** @brief Static class with helper functions for generating HTML code.
 */
class SET_Html
{
  /** Counter for generating unique element ID's. See method @a GetAutoId.
   */
  private static $ourAutoId = 0;

  //--------------------------------------------------------------------------------------------------------------------
  /** Throws an exception with text @a $theMessage.
   */
  public static function Error()
  {
    $args   = func_get_args();
    $format = array_shift( $args );

    foreach( $args as &$arg )
    {
      if (!is_scalar( $arg )) $arg = var_export( $arg, true );
    }

    throw new Exception( vsprintf( $format, $args ) );
  }

  //--------------------------------------------------------------------------------------------------------------------
  public static function Txt2Html( $theText )
  {
    return htmlspecialchars( $theText, ENT_QUOTES, 'UTF-8' );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /** Returns a string with attribute @a $theName with value @a $theValue, e.g. type='text'. This function takes care
   *  about proper escaping of @a $theValue.
   */
  public static function GenerateAttribute( $theName, $theValue )
  {
    $ret= 'xxxx';
    switch ($theName)
    {
      // Plain text attributes
      case 'accept':
      case 'accept-charsets':
      case 'accesskey':
      case 'action':
      case 'alt':
      case 'charset':
      case 'class':
      case 'cols':
      case 'colspan':
      case 'coords':
      case 'dir':
      case 'enctype':
      case 'href':
      case 'hreflang':
      case 'id':
      case 'maxlength':
      case 'method':
      case 'name':
      case 'rel':
      case 'rev':
      case 'rows':
      case 'shape':
      case 'size':
      case 'src':
      case 'style':
      case 'tabindex':
      case 'title':
      case 'type':
      case 'usemap':
      case 'value':
      case 'xml:lang':
        if ($theValue!==null && $theValue!==false && $theValue!=='')
        {
          $ret  = " $theName='";
          $ret .= htmlspecialchars( $theValue, ENT_QUOTES, 'UTF-8' );
          $ret .= "'";
        }
        break;


      // Boolean attributes
      case 'checked':
      case 'disabled':
      case 'ismap':
      case 'multiple':
      case 'readonly':
        if (!empty($theValue)) $ret = " $theName='$theName'";
        break;


      // Event attributes
      case 'onblur':
      case 'onchange':
      case 'onclick':
      case 'ondbclick':
      case 'onfocus':
      case 'onkeydown':
      case 'onkeypress':
      case 'onkeyup':
      case 'onmousedown':
      case 'onmouseout':
      case 'onmouseover':
      case 'onmouseup':
      case 'onreset':
      case 'onselect':
      case 'onsubmit':
        /** @todo proper escaping of javascript */
        if ($theValue!==null && $theValue!==false && $theValue!=='') $ret = " $theName=\"$theValue\"";
        break;
    }

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /** Returns a string that can be safely used an ID for an element. The format of the id is 'h2o_<n>' where n is
   * incremented with call to @a GetAutoId.
   */
  public static function GetAutoId()
  {
    self::$ourAutoId++;

    return 'set_'.self::$ourAutoId;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
