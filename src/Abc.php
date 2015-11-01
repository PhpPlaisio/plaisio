<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc;

use SetBased\Abc\Core\Page\Misc\LoginPage;
use SetBased\Abc\Error\InvalidUrlException;
use SetBased\Abc\Error\NotAuthorizedException;
use SetBased\Abc\Helper\Http;
use SetBased\Abc\Obfuscator\Obfuscator;
use SetBased\Abc\Obfuscator\ObfuscatorFactory;
use SetBased\Abc\Page\Page;
use SetBased\Stratum\Exception\ResultException;
use SetBased\Stratum\MySql\StaticDataLayer;

//----------------------------------------------------------------------------------------------------------------------
/**
 * The main helper class for the ABC Abc.
 *
 * @todo Use composition for exception and request logging.
 */
abstract class Abc
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @var Object
   */
  public static $DL;

  /**
   * The start time of serving the page request.
   *
   * @var float
   */
  public static $ourTime0;

  /**
   * The factory for creating Obfuscators.
   *
   * @var ObfuscatorFactory
   */
  protected static $ourObfuscatorFactory;

  /**
   * @var Abc A reference to the singleton instance of this class.
   */
  private static $ourInstance;

  /**
   * The canonical host name of the (virtual) web server.
   *
   * @var string
   */
  protected $myCanonicalServerName;

  /**
   * The domain (a.k.a. company abbreviation).
   *
   * @var string
   */
  protected $myDomain;

  /**
   * The ID of the requested page.
   */
  private $myPagId;

  /**
   * Information about the requested page.
   */
  private $myPageInfo;

  /**
   * The size of the generated page.
   *
   * @var int
   */
  private $myPageSize;

  /**
   * The request log ID (rql_id).
   *
   * @var int
   */
  private $myRqlId;

  /**
   * Information about the session.
   *
   * @var array
   */
  private $mySessionInfo;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param StaticDataLayer   $theDataLayer         The data layer generated by PhpStratum.
   * @param ObfuscatorFactory $theObfuscatorFactory The factory for creating obfuscator objects.
   */
  protected function __construct($theDataLayer, $theObfuscatorFactory)
  {
    self::$ourInstance = $this;

    self::$DL = $theDataLayer;

    self::$ourObfuscatorFactory = $theObfuscatorFactory;

    // Derive the canonical server name aka fully qualified server name.
    $this->setCanonicalServerName();

    // Derive the domain (a.k.a. company abbreviation).
    $this->setDomain();

    // Get the CGI variables from a clean URL.
    $this->uncleanUrl();

    // Derive the ID of the requested page.
    $this->derivePagId();

    // Retrieve the session or create an new session.
    $this->getSession();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * De-obfuscate an obfuscated database ID.
   *
   * @param string $theCode  The obfuscated database ID.
   * @param string $theLabel An alias for the column holding the ID's.
   *
   * @return string
   */
  public static function deObfuscate($theCode, $theLabel)
  {
    return self::$ourObfuscatorFactory->decode($theCode, $theLabel);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the singleton instance of this class.
   *
   * @return Abc The singleton instance.
   */
  public static function getInstance()
  {
    return self::$ourInstance;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns an Obfuscator for obfuscating and de-obfuscating database ID's.
   *
   * @param string $theLabel An alias for the column holding the ID's.
   *
   * @return Obfuscator
   */
  public static function getObfuscator($theLabel)
  {
    return self::$ourObfuscatorFactory->getObfuscator($theLabel);
  }
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Obfuscates a database ID.
   *
   * @param int    $theId    The database ID.
   * @param string $theLabel An alias for the column holding the ID's.
   *
   * @return string
   */
  public static function obfuscate($theId, $theLabel)
  {
    return self::$ourObfuscatorFactory->encode($theId, $theLabel);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Appends with a separator a string to the page title
   *
   * @param string $thePageTitleAddendum The string to eb append to the page title.
   */
  public function appendPageTitle($thePageTitleAddendum)
  {
    $this->myPageInfo['pag_title'] .= ' - ';
    $this->myPageInfo['pag_title'] .= $thePageTitleAddendum;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Check exist info for current page. If exist return true, otherwise false.
   */
  public function checkPageInfo()
  {
    if ($this->myPageInfo) return true;

    return false;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the canonical server name of the (virtual) web server. This method is preferred over $_SERVER['HTTP_HOST']
   * and $_SERVER['SERVER_NAME'].
   *
   * @return string
   */
  public function getCanonicalServerName()
  {
    return $this->myCanonicalServerName;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the domain (a.k.a. company) of the requestor.
   */
  public function getCmpId()
  {
    return $this->mySessionInfo['cmp_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns stateful double submit token to prevent CSRF attacks.
   *
   * @return string
   */
  public function getCsrfToken()
  {
    return $this->mySessionInfo['ses_csrf_token'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the domain of the page request.
   *
   * @return string
   */
  public function getDomain()
  {
    return $this->myDomain;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the code of the preferred language of the requestor.
   *
   * @return string
   */
  public function getLanCode()
  {
    return $this->mySessionInfo['lan_code'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the preferred language of the requestor.
   *
   * @return int
   */
  public function getLanId()
  {
    return $this->mySessionInfo['lan_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns ID of the menu item associated with the requested page.
   *
   * @return int
   */
  public function getMnuId()
  {
    return $this->myPageInfo['mnu_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the requested page.
   *
   * @return int
   */
  public function getPagId()
  {
    return $this->myPagId;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   *
   */
  public function getPagIdOrg()
  {
    return $this->myPageInfo['pag_id_org'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the class for handling the page request.
   *
   * @return string
   */
  public function getPageClass()
  {
    return $this->myPageInfo['pag_class'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the source file with the class for handling the page request.
   */
  public function getPageFile()
  {
    return $this->myPageInfo['pag_file'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns page group title.
   */
  public function getPageGroupTitle()
  {
    return $this->myPageInfo['ptb_title'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns info of the requested page.
   *
   * @return array
   */
  public function getPageInfo()
  {
    return $this->myPageInfo;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns page title.
   *
   * @return string
   */
  public function getPageTitle()
  {
    return $this->myPageInfo['pag_title'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns page group title.
   *
   * @return string
   */
  public function getPtbId()
  {
    return $this->myPageInfo['ptb_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the session.
   *
   * @return int
   */
  public function getSesId()
  {
    return $this->mySessionInfo['ses_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the session info.
   *
   * @return array
   */
  public function getSessionInfo()
  {
    return $this->mySessionInfo;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the user ID of the requestor.
   *
   * @return int
   */
  public function getUsrId()
  {
    return $this->mySessionInfo['usr_id'];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles the actual page request including authorization and security checking, transaction handling,
   * request logging, and exception handling.
   */
  public function handlePageRequest()
  {
    // Start output buffering.
    ob_start();

    try
    {
      // Test the user is authorized for the requested page.
      $this->checkAuthorization();

      $page_class = $this->myPageInfo['pag_class'];
      try
      {
        /** @var Page $page */
        $page = new $page_class();
      }
      catch (ResultException $e)
      {
        // A ResultException during the construction of a page object is (almost) always caused by an invalid URL.
        throw new InvalidUrlException('No data found', $e);
      }

      $uri = $page->getPreferredUri();
      if (isset($uri) && $uri!=$_SERVER['REQUEST_URI'])
      {
        // The preferred URI differs from the requested URI. Redirect the user agent to the preferred URL.
        Abc::$DL->rollback();
        Http::redirect($uri, Http::HTTP_MOVED_PERMANENTLY);
      }
      else
      {
        // Echo the page content.
        $page->echoPage();

        // Flush the page content.
        ob_flush();

        $this->myPageSize = $page->getPageSize();
      }
    }
    catch (NotAuthorizedException $e)
    {
      // The user has no authorization for the requested URL.
      $this->handleNotAuthorizedException($e);
    }
    catch (InvalidUrlException $e)
    {
      // The URL is invalid.
      $this->handleInvalidUrlException($e);
    }
    catch (\Exception $e)
    {
      // Some other exception has occurred.
      $this->handleException($e);
    }

    $this->updateSession();
    $this->requestLog();

    Abc::$DL->commit();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns true if the requestor is anonymous. Returns false otherwise.
   *
   * @return bool
   */
  public function isAnonymous()
  {
    return (!empty($this->mySessionInfo['usr_anonymous']));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets title for current page.
   *
   * @param string $thePageTitle The new title of the page.
   */
  public function setPageTitle($thePageTitle)
  {
    $this->myPageInfo['pag_title'] = $thePageTitle;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Derives the ID of the requested page.
   */
  protected function derivePagId()
  {
    if (isset($_GET['pag']))
    {
      $this->myPagId = Abc::deObfuscate($_GET['pag'], 'pag');
    }
    else if (isset($_GET['page']))
    {
      switch ($_GET['page'])
      {
        case 'w3c_validate':
          $this->myPagId = C::PAG_ID_MISC_W3C_VALIDATE;
          break;

        default:
          // xxx what to do? Exception or use index?
          $this->myPagId = C::PAG_ID_MISC_INDEX;
      }
    }
    else
    {
      $this->myPagId = C::PAG_ID_MISC_INDEX;
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles any other caught exception.
   *
   * @param \Exception $theException The caught exception.
   */
  protected function handleException($theException)
  {
    $this->logException($theException);
    Abc::$DL->rollback();
    // Set the HTTP status to 500 (Internal Server Error).
    Http::error(Http::HTTP_INTERNAL_SERVER_ERROR);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles a caught InvalidUrlException.
   *
   * @param InvalidUrlException $theException The caught exception.
   */
  protected function handleInvalidUrlException($theException)
  {
    $this->logException($theException);
    Abc::$DL->rollback();
    // Set the HTTP status to 404 (Not Found).
    Http::error(Http::HTTP_NOT_FOUND);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles a caught NotAuthorizedException.
   *
   * @param NotAuthorizedException $theException The caught exception.
   */
  protected function handleNotAuthorizedException($theException)
  {
    if ($this->isAnonymous())
    {
      // The user is not logged on and most likely the user has requested a page for which the user must be logged on.
      Abc::$DL->rollback();
      // Redirect the user agent to the login page. After the user has successfully logged on the user agent will be
      // redirected to currently requested URL.
      Http::redirect(LoginPage::getUrl($_SERVER['REQUEST_URI']));
    }
    else
    {
      // The user is logged on and the user has requested an URL for which the user has no authorization.
      $this->logException($theException);
      Abc::$DL->rollback();
      // Set the HTTP status to 404 (Not Found).
      Http::error(Http::HTTP_NOT_FOUND);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Gets the CGI variables from the clean URL and enhances $_GET.
   */
  protected function uncleanUrl()
  {
    $uri = (isset($_SERVER['REQUEST_URI'])) ? substr($_SERVER['REQUEST_URI'], 1) : '';
    $i   = strpos($uri, '?');
    if ($i!==false) $uri = substr($uri, 0, $i);

    $urlParts = explode('/', $uri);

    // if ($urlParts[count($urlParts) - 1] == '') array_pop($urlParts);

    $urlPartsCount = count($urlParts);
    if ($urlPartsCount % 2!=0) $urlPartsCount++;
    for ($i = 0; $i<$urlPartsCount; $i += 2)
    {
      $key        = $urlParts[$i];
      $value      = (isset($urlParts[$i + 1])) ? $urlParts[$i + 1] : null;
      $_GET[$key] = urldecode($value);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Retrieves information about the requested page and checks if the user has the correct authorization for the
   * requested page.
   */
  private function checkAuthorization()
  {
    $this->myPageInfo = Abc::$DL->authGetPageInfo($this->mySessionInfo['cmp_id'],
                                                  $this->myPagId,
                                                  $this->mySessionInfo['usr_id'],
                                                  $this->mySessionInfo['lan_id']);
    if (!$this->myPageInfo)
    {
      throw new NotAuthorizedException("User %d is not authorized for page '%d'.",
                                       $this->mySessionInfo['usr_id'],
                                       $this->myPagId);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Retrieves the session from the database based on the session cookie (ses_session_token) and sets the cookies
   * ses_session_token and ses_csrf_token.
   */
  private function getSession()
  {
    $this->mySessionInfo = Abc::$DL->sessionGetSession($this->myDomain,
                                                       isset($_COOKIE['ses_session_token']) ? $_COOKIE['ses_session_token'] : null);

    if (isset($_SERVER['HTTPS']))
    {
      // Set session and CSRF cookies.
      setcookie('ses_session_token', $this->mySessionInfo['ses_session_token'], false, '/', $_SERVER['HTTP_HOST'], true, true);
      setcookie('ses_csrf_token', $this->mySessionInfo['ses_csrf_token'], false, '/', $_SERVER['HTTP_HOST'], true, false);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Writes a exception message to a log file.
   *
   * To the log file are written:
   * * The exception message.
   * * The stack trace.
   * * The server variables $_SERVER.
   * * The post variables $_POST.
   * * The cgi parameters $_GET.
   * * The environment variables $_ENV.
   * * The file variables $_FILE.
   * * The session info $mySessionInfo.
   * * The page info $myPageInfo.
   *
   * @param \Exception $theException
   */
  private function logException($theException)
  {
    list($usec, $sec) = explode(" ", microtime());
    $file_name = DIR_ERROR."/error-".($sec + $usec).".log";
    $fp        = fopen($file_name, "a");

    $message = '';
    $e       = $theException;
    while ($e)
    {
      $message .= $e->getMessage();
      $message .= "\n\n";

      $message .= $e->getTraceAsString();
      $message .= "\n\n";

      $e = $e->getPrevious();
      if ($e)
      {
        $message .= "This exception has been caused by the following exception:";
        $message .= "\n";
      }
    }

    $message .= "Server variables\n";
    $message .= print_r($_SERVER, true);
    $message .= "\n\n";

    $message .= "Post variables\n";
    $message .= print_r($_POST, true);
    $message .= "\n\n";

    $message .= "Get variables\n";
    $message .= print_r($_GET, true);
    $message .= "\n\n";

    $message .= "Cookie variables\n";
    $message .= print_r($_COOKIE, true);
    $message .= "\n\n";

    $message .= "Environment variables\n";
    $message .= print_r($_ENV, true);
    $message .= "\n\n";

    $message .= "File variables\n";
    $message .= print_r($_FILES, true);
    $message .= "\n\n";

    $message .= "Session info\n";
    $message .= print_r($this->mySessionInfo, true);
    $message .= "\n\n";

    $message .= "System info\n";
    $message .= print_r($this->myPageInfo, true);
    $message .= "\n\n";

    fwrite($fp, $message);
    fclose($fp);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs the page request in to the DB.
   */
  private function requestLog()
  {
    $this->myRqlId = Abc::$DL->RequestLogLogRequest(
      $this->mySessionInfo['ses_id'],
      $this->mySessionInfo['cmp_id'],
      $this->mySessionInfo['usr_id'],
      $this->myPagId,
      mb_substr($_SERVER['REQUEST_URI'], 0, 255),
      mb_substr($_SERVER['REQUEST_METHOD'], 0, 8),
      (isset($_SERVER['HTTP_REFERER'])) ? mb_substr($_SERVER['HTTP_REFERER'], 0, 255) : null,
      $_SERVER['REMOTE_ADDR'],
      (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 64) : null,
      (isset($_SERVER['HTTP_USER_AGENT'])) ? mb_substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : null,
      0, // XXX query count
      microtime(true) - self::$ourTime0,
      $this->myPageSize);

    // $this->requestLogQuery();
    // $this->requestLogPost( $_POST );
    // $this->requestLogCookie( $_COOKIE );
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs the (by the client) sent cookies in to the database.
   *
   * Usage on this method on production environments is disguised.
   *
   * @param array  $theCookies  must be $_COOKIES
   * @param string $theVariable must not be used, intended for use by recursive calls only.
   */
  private function requestLogCookie($theCookies, $theVariable = null)
  {
    if (is_array($theCookies))
    {
      foreach ($theCookies as $index => $value)
      {
        if (isset($theVariable)) $variable = $theVariable.'['.$index.']';
        else                     $variable = $index;

        if (is_array($value))
        {
          $this->requestLogCookie($value, $variable);
        }
        else
        {
          Abc::$DL->RequestLogInsertCookie($this->myRqlId, $variable, $value);
        }
      }
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Logs the post variables in to the database.
   *
   * Usage on this method on production environments is not recommended.
   *
   * @param array  $thePost     Must be $_POST (except for recursive calls).
   * @param string $theVariable Must not be used (except for recursive calls).
   */
  private function requestLogPost($thePost, $theVariable = null)
  {
    if (is_array($thePost))
    {
      foreach ($thePost as $index => $value)
      {
        if (isset($theVariable)) $variable = $theVariable.'['.$index.']';
        else                     $variable = $index;

        if (is_array($value))
        {
          $this->requestLogPost($value, $variable);
        }
        else
        {
          Abc::$DL->RequestLogInsertPost($this->myRqlId, $variable, $value);
        }
      }
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the canonical server name (a.k.a. hostname). This canonical server name is derived from $_SERVER.
   */
  private function setCanonicalServerName()
  {
    if (!empty($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
      $hostname = (end(explode(',', $_SERVER['HTTP_X_FORWARDED_HOST'])));
    }
    elseif (!empty($_SERVER['HTTP_HOST']))
    {
      $hostname = $_SERVER['HTTP_HOST'];
    }
    elseif (!empty($_SERVER['SERVER_NAME']))
    {
      $hostname = $_SERVER['SERVER_NAME'];
    }
    elseif (!empty($_SERVER['SERVER_ADDR']))
    {
      $hostname = $_SERVER['SERVER_ADDR'];
    }
    else
    {
      $hostname = '';
    }

    // Remove port number, if any.
    $p = strpos($hostname, ':');
    if ($p!==false) $hostname = substr($hostname, 0, $p);

    $this->myCanonicalServerName = strtolower(trim($hostname));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the domain (or Company abbreviation) based on the third level domain (TLD) name of the canonical host name.
   */
  private function setDomain()
  {
    // If possible derive domain from the canonical server name.
    $parts = explode('.', $this->myCanonicalServerName);
    if (count($parts)==3 && $parts[0]!='www')
    {
      $this->myDomain = strtoupper($parts[0]);
    }
    else
    {
      $this->myDomain = 'SYS';
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the session in the DB.
   */
  private function updateSession()
  {
    self::$DL->sessionUpdate($this->getSesId());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
