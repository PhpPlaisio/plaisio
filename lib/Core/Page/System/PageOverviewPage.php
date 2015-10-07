<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Core\Page\System;

use SetBased\Abc\Abc;
use SetBased\Abc\C;
use SetBased\Abc\Core\Page\CorePage;
use SetBased\Abc\Core\Table\OverviewTable;
use SetBased\Abc\Core\TableAction\System\PageInsertTableAction;
use SetBased\Abc\Core\TableColumn\System\PageDetailsIconTableColumn;
use SetBased\Abc\Core\TableColumn\System\PageUpdateIconTableColumn;
use SetBased\Html\TableColumn\NumericTableColumn;
use SetBased\Html\TableColumn\TextTableColumn;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Page with an overview all pages.
 */
class PageOverviewPage extends CorePage
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the relative URL for this page.
   *
   * @return string
   */
  public static function getUrl()
  {
    return '/pag/'.Abc::obfuscate(C::PAG_ID_SYSTEM_PAGE_OVERVIEW, 'pag');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function echoTabContent()
  {
    $pages = Abc::$DL->SystemPageGetAll($this->myLanId);

    $table = new OverviewTable($this->myCmpId, $this->myUsrId);
    $table->addTableAction('default', new PageInsertTableAction());

    // Show page ID.
    $table->addColumn(new NumericTableColumn('ID', 'pag_id'));

    // Show class name.
    $col = $table->addColumn(new TextTableColumn('Class', 'pag_class'));
    $col->sortOrder(1);

    // Show title of page.
    $table->addColumn(new TextTableColumn('Title', 'pag_title'));

    // Show label of the page ID.
    $table->addColumn(new TextTableColumn('Label', 'pag_label'));

    // Show associated menu item of the page.
    $table->addColumn(new TextTableColumn('Menu', 'mnu_name'));

    // Show page tab of the page.
    $table->addColumn(new TextTableColumn('Page Tab', 'ptb_label'));

    // Show modifying the page.
    $table->addColumn(new PageDetailsIconTableColumn($this->myLanId));

    // Add column with link to the details of the page.
    $table->addColumn(new PageUpdateIconTableColumn($this->myLanId));

    echo $table->getHtmlTable($pages);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

