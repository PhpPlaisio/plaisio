<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Core\TableAction;

use SetBased\Abc\Helper\Html;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Parent class for table actions for inserting certain items.
 */
class InsertItemTableAction implements TableAction
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The title of the icon of the table action.
   *
   * @var string
   */
  protected $myTitle;

  /**
   * The URL of the table action.
   *
   * @var string
   */
  protected $myUrl;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function getHtml()
  {
    $ret = '<a';
    $ret .= Html::generateAttribute('href', $this->myUrl);
    $ret .= '><img';
    $ret .= Html::generateAttribute('title', $this->myTitle);
    $ret .= Html::generateAttribute('src', ICON_ADD);
    $ret .= ' width="16" height="16" alt="add"/></a>';

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
