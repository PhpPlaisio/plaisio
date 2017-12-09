<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc;

use SetBased\Abc\Babel\Babel;
use SetBased\Abc\BlobStore\BlobStore;
use SetBased\Abc\CanonicalHostnameResolver\CanonicalHostnameResolver;
use SetBased\Abc\CompanyResolver\CompanyResolver;
use SetBased\Abc\ErrorLogger\ErrorLogger;
use SetBased\Abc\LanguageResolver\LanguageResolver;
use SetBased\Abc\Lock\EntityLock;
use SetBased\Abc\Lock\NamedLock;
use SetBased\Abc\Login\LoginHandler;
use SetBased\Abc\Mail\MailMessage;
use SetBased\Abc\Obfuscator\Obfuscator;
use SetBased\Abc\Obfuscator\ObfuscatorFactory;
use SetBased\Abc\Request\Request;
use SetBased\Abc\RequestHandler\RequestHandler;
use SetBased\Abc\RequestLogger\RequestLogger;
use SetBased\Abc\RequestParameterResolver\RequestParameterResolver;
use SetBased\Abc\Session\Session;
use SetBased\Abc\WebAssets\WebAssets;

/**
 * The main class for the ABC-Framework.
 */
abstract class Abc
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The data layer generated by PhpStratum.
   *
   * @var Object
   */
  public static $DL;

  /**
   * A reference to the singleton instance of this class.
   *
   * @var Abc
   */
  public static $abc;

  /**
   * The helper object for web assets.
   *
   * @var WebAssets
   */
  public static $assets;

  /**
   * The Babel object for retrieving linguistic entities.
   *
   * @var Babel
   */
  public static $babel;

  /**
   * The helper object for deriving the canonical hostname.
   *
   * @var CanonicalHostnameResolver
   */
  public static $canonicalHostnameResolver;

  /**
   * The helper object for deriving the company.
   *
   * @var CompanyResolver
   */
  public static $companyResolver;

  /**
   * The helper object for resolving the code of the language in which the response must be drafted.
   *
   * @var LanguageResolver
   */
  public static $languageResolver;

  /**
   * The helper object for providing information about the HTTP request.
   *
   * @var Request
   */
  public static $request;

  /**
   * The helper object for handling the HTTP page request.
   *
   * @var RequestHandler
   */
  public static $requestHandler;

  /**
   * The helper object for logging HTTP page requests.
   *
   * @var RequestLogger
   */
  public static $requestLogger;

  /**
   * The helper object for resolving the CGI parameters from a clean URL.
   *
   * @var RequestParameterResolver
   */
  public static $requestParameterResolver;

  /**
   * The helper object for session management.
   *
   * @var Session
   */
  public static $session;

  /**
   * The start time of serving the page request.
   *
   * @var float
   */
  public static $time0;

  /**
   * The factory for creating Obfuscators.
   *
   * @var ObfuscatorFactory
   */
  protected static $obfuscatorFactory;

  /**
   * Information about the requested page.
   *
   * {@deprecated}
   *
   * @var array
   */
  public $pageInfo;

  //--------------------------------------------------------------------------------------------------------------------

  /**
   * Object constructor.
   */
  protected function __construct()
  {
    self::$abc = $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * De-obfuscates an obfuscated database ID.
   *
   * @param string $code  The obfuscated database ID.
   * @param string $alias An alias for the column holding the IDs.
   *
   * @return int
   */
  public static function deObfuscate($code, $alias)
  {
    return self::$obfuscatorFactory->decode($code, $alias);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns an Obfuscator for obfuscating and de-obfuscating database IDs.
   *
   * @param string $alias An alias for the column holding the IDs.
   *
   * @return Obfuscator
   */
  public static function getObfuscator($alias)
  {
    return self::$obfuscatorFactory->getObfuscator($alias);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Obfuscates a database ID.
   *
   * @param int    $id    The database ID.
   * @param string $alias An alias for the column holding the IDs.
   *
   * @return string
   */
  public static function obfuscate($id, $alias)
  {
    return self::$obfuscatorFactory->encode($id, $alias);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Check exist info for current page. If exist return true, otherwise false.
   *
   * {@deprecated}
   */
  public function checkPageInfo()
  {
    if (!empty($this->pageInfo)) return true;

    return false;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Acquires a lock on a database entity and returns the object holding the lock.
   *
   * @param int $nameId   The ID of the name of the entity lock.
   * @param int $entityId The ID of the entity.
   *
   * @return EntityLock
   */
  public function createEntityLock($nameId, $entityId)
  {
    unset($nameId);
    unset($entityId);

    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns a login handler for logging in a user agent.
   *
   * @return LoginHandler
   */
  public function createLoginHandler()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates an empty mail message.
   *
   * @return MailMessage
   */
  public function createMailMessage()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Acquires a named lock and returns the object holding the lock.
   *
   * @param int $id The ID of the named lock.
   *
   * @return NamedLock
   */
  public function createNamedLock($id)
  {
    unset($id);

    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the BLOB Store object.
   *
   * @return BlobStore
   */
  public function getBlobStore()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the error logger.
   *
   * @return ErrorLogger
   */
  public function getErrorLogger()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the index page.
   *
   * @return int
   */
  public function getIndexPagId()
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the URL of the login page.
   *
   * @param string|null $redirect After a successful login the user agent must be redirected to this URL.
   *
   * @return string
   */
  public function getLoginUrl($redirect = null)
  {
    unset($redirect);

    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns ID of the menu item associated with the requested page.
   *
   * {@deprecated}
   *
   * @return int
   */
  public function getMnuId()
  {
    return $this->pageInfo['mnu_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the requested page.
   *
   * {@deprecated}
   *
   * @return int
   */
  public function getPagId()
  {
    return $this->pageInfo['pag_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the "original" page.
   *
   * {@deprecated}
   *
   * @return int
   */
  public function getPagIdOrg()
  {
    return $this->pageInfo['pag_id_org'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns page group title.
   *
   * {@deprecated}
   *
   * @return string
   */
  public function getPageGroupTitle()
  {
    return $this->pageInfo['ptb_title'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns true if the current user is authorized the request a page.
   *
   * {@deprecated}
   *
   * @param int $pagId The ID of the page.
   *
   * @return bool
   */
  public function getPathAuth($pagId)
  {
    return self::$DL->abcAuthGetPageAuth(self::$companyResolver->getCmpId(), self::$session->getProId(), $pagId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns page group title.
   *
   * {@deprecated}
   *
   * @return string
   */
  public function getPtbId()
  {
    return $this->pageInfo['ptb_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles the actual page request including authorization and security checking, transaction handling,
   * request logging, and exception handling.
   */
  public function handlePageRequest()
  {
    self::$requestHandler->handleRequest();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
