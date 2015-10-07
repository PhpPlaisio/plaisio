<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Helper;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Static class with helper functions for generating HTML code.
 */
class Http
{
  //--------------------------------------------------------------------------------------------------------------------
  const HTTP_MOVED_PERMANENTLY = 301;
  const HTTP_NOT_FOUND = 404;
  const HTTP_INTERNAL_SERVER_ERROR = 500;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * List of HTTP status codes and the corresponding texts.
   *
   * @var array
   */
  public static $ourHttpStatuses = [100 => 'Continue',
                                    101 => 'Switching Protocols',
                                    102 => 'Processing',
                                    118 => 'Connection timed out',
                                    200 => 'OK',
                                    201 => 'Created',
                                    202 => 'Accepted',
                                    203 => 'Non-Authoritative',
                                    204 => 'No Content',
                                    205 => 'Reset Content',
                                    206 => 'Partial Content',
                                    207 => 'Multi-Status',
                                    208 => 'Already Reported',
                                    210 => 'Content Different',
                                    226 => 'IM Used',
                                    300 => 'Multiple Choices',
                                    301 => 'Moved Permanently',
                                    302 => 'Found',
                                    303 => 'See Other',
                                    304 => 'Not Modified',
                                    305 => 'Use Proxy',
                                    306 => 'Reserved',
                                    307 => 'Temporary Redirect',
                                    308 => 'Permanent Redirect',
                                    310 => 'Too many Redirect',
                                    400 => 'Bad Request',
                                    401 => 'Unauthorized',
                                    402 => 'Payment Required',
                                    403 => 'Forbidden',
                                    404 => 'Not Found',
                                    405 => 'Method Not Allowed',
                                    406 => 'Not Acceptable',
                                    407 => 'Proxy Authentication Required',
                                    408 => 'Request Time-out',
                                    409 => 'Conflict',
                                    410 => 'Gone',
                                    411 => 'Length Required',
                                    412 => 'Precondition Failed',
                                    413 => 'Request Entity Too Large',
                                    414 => 'Request-URI Too Long',
                                    415 => 'Unsupported Media Type',
                                    416 => 'Requested range unsatisfiable',
                                    417 => 'Expectation failed',
                                    418 => 'I\'m a teapot',
                                    422 => 'Unprocessable entity',
                                    423 => 'Locked',
                                    424 => 'Method failure',
                                    425 => 'Unordered Collection',
                                    426 => 'Upgrade Required',
                                    428 => 'Precondition Required',
                                    429 => 'Too Many Requests',
                                    431 => 'Request Header Fields Too Large',
                                    449 => 'Retry With',
                                    450 => 'Blocked by Windows Parental Controls',
                                    500 => 'Internal Server Error',
                                    501 => 'Not Implemented',
                                    502 => 'Bad Gateway or Proxy Error',
                                    503 => 'Service Unavailable',
                                    504 => 'Gateway Time-out',
                                    505 => 'HTTP Version not supported',
                                    507 => 'Insufficient storage',
                                    508 => 'Loop Detected',
                                    509 => 'Bandwidth Limit Exceeded',
                                    510 => 'Not Extended',
                                    511 => 'Network Authentication Required'];

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the status code for the HTTP request to a client or server error.
   *
   * The output buffer will be erased, see [ob_clean](http://php.net/manual/function.ob-clean.php).
   *
   * @param int $theStatusCode The HTTP status code, must be a 4xx (client error) or 5xx (server error) status code. See
   *                           <http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html> for details about HTTP status
   *                           codes.
   */
  public static function error($theStatusCode)
  {
    ob_clean();
    header('HTTP/1.1 '.$theStatusCode.' '.self::$ourHttpStatuses[$theStatusCode]);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Redirects the user agent to a specified URL.
   *
   * The output buffer will be erased, see [ob_clean](http://php.net/manual/function.ob-clean.php).
   *
   * This method will protect against unvalidated redirects, see
   * <https://www.owasp.org/index.php/Unvalidated_Redirects_and_Forwards_Cheat_Sheet>.
   *
   * @param string $theUrl               The URL to redirect the user agent.
   * @param int    $theStatusCode        The HTTP status code. See
   *                                     <http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html> for details about
   *                                     HTTP status codes.
   * @param bool   $theForceRelativeFlag If set the URL will be validated to be a relative URL, if not so the URL will
   *                                     be replaced with '/'.
   */
  public static function redirect($theUrl, $theStatusCode = 303, $theForceRelativeFlag = true)
  {
    $url = ($theForceRelativeFlag && Url::isRelative($theUrl)) ? $theUrl : '/';

    ob_clean();
    header('HTTP/1.1 '.$theStatusCode.' '.self::$ourHttpStatuses[$theStatusCode]);
    header('location: '.$url);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
