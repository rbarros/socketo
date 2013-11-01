<?php namespace MyApp;

class Url {

    /**
     * Retorna o protocolo utilizado
     * @return string
     */
    public static function getScheme(){
        $protocol='http';
        
        if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS']=='on'){
          $protocol.='s';
        }
        return $protocol;
    }

    /**
     * Retorna o host:porta utilizado
     * @return string
     */
    public static function getHttpHost(){
        if(isset($_SERVER['SERVER_PORT']) and ($_SERVER['SERVER_PORT']!='80' and $_SERVER['SERVER_PORT']!='443') ){
          $host = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
        } else {
          $host = $_SERVER['SERVER_NAME'];
        }
        return $host;
    }

    /**
     * Retorna a pasta correspondente
     * Retirado de Symfony\Component\HttpFoundation\Request
     * @return string
     */
    public static function getBasePath(){
      $filename = basename($_SERVER['SCRIPT_FILENAME']);

      $requestUri = $_SERVER['REQUEST_URI'];

      if(stripos($_SERVER['REQUEST_URI'], basename($_SERVER['SCRIPT_NAME']) ) === false) {
          $baseUrl = "{$_SERVER['SCRIPT_NAME']}";
          $requestUri = "{$baseUrl}?{$_SERVER['QUERY_STRING']}";
      } elseif (basename($_SERVER['SCRIPT_NAME']) === $filename) {
          $baseUrl = $_SERVER['SCRIPT_NAME'];
      } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
          $baseUrl = $_SERVER['PHP_SELF'];
      } elseif (basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
          $baseUrl = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
      } else {
          // Backtrack up the script_filename to find the portion matching
          // php_self
          $path    = $_SERVER['PHP_SELF'] || '';
          $file    = $_SERVER['SCRIPT_FILENAME'] || '';
          $segs    = explode('/', trim($file, '/'));
          $segs    = array_reverse($segs);
          $index   = 0;
          $last    = count($segs);
          $baseUrl = '';
          do {
              $seg     = $segs[$index];
              $baseUrl = '/'.$seg.$baseUrl;
              ++$index;
          } while (($last > $index) && (false !== ($pos = strpos($path, $baseUrl))) && (0 != $pos));
      }

      $len = strlen($baseUrl);
      if (preg_match("#^(%[[:xdigit:]]{2}|.){{$len}}#", $requestUri, $match)) {
          $baseUrl = $match[0];
      }
      if (empty($baseUrl)) {
          return '';
      }

      if (basename($baseUrl) === $filename) {
          $basePath = dirname($baseUrl);
      } else {
          $basePath = $baseUrl;
      }

      if ('\\' === DIRECTORY_SEPARATOR) {
          $basePath = str_replace('\\', '/', $basePath);
      }
      return rtrim($basePath, '/');
    }

    /**
     * Retorna a url atual
     * @return string
     */
    public static function getBaseUrl(){
        return self::getScheme().'://'.self::getHttpHost().self::getBasePath();
    }

    /**
     * Retorna a url do assets
     * @param  string $file arquivo adicionado na url
     * @return string       retorna a url da pasta assets
     */
    public static function asset($file=null){
      return trim(Url::getBaseUrl(),'/').'/assets/'.$file;
    }
}