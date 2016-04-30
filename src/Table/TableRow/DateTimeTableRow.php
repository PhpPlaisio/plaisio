<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Table\TableRow;

use SetBased\Abc\Helper\Html;
use SetBased\Abc\Table\DetailTable;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Table row in a detail table with a date and time.
 */
class DateTimeTableRow
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The default format of the date-time if the format specifier is omitted in the constructor.
   *
   * @var string
   */
  public static $defaultFormat = 'd-m-Y H:i:s';

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a row with a datetime value to a detail table.
   *
   * @param DetailTable $table     The (detail) table.
   * @param string      $header    The row header text.
   * @param string      $value     The datetime in Y-m-d H:i:s format.
   * @param string|null $format    The format specifier for formatting the content of this table column. If null
   *                               the default format is used.
   */
  public static function addRow($table, $header, $value, $format = null)
  {
    $row = '<tr>';

    $row .= '<th>';
    $row .= Html::txt2Html($header);
    $row .= '</th>';

    $date = \DateTime::createFromFormat('Y-m-d', $value);

    if ($date)
    {
      // The $theValue is a valid date.
      $row .= '<td class="date" data-value="';
      $row .= $date->format('Y-m-d');
      $row .= '">';
      $row .= Html::txt2Html($date->format(($format) ? $format : self::$defaultFormat));
      $row .= '</td>';
    }
    else
    {
      // The $theValue is not a valid datetime.
      $row .= '<td>';
      $row .= Html::txt2Html($value);
      $row .= '</td>';
    }

    $row .= '</tr>';

    $table->addRow($row);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
