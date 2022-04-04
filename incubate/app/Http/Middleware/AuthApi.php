<?php
namespace App\Http\Middleware;
use Closure;
class AuthApi 
{
    public function handle($request, Closure $next)
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
            header("Access-Control-Allow-Headers: x-api-key");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
            header("Access-Control-Allow-Headers: x-api-key");
            header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
        }
        $data = $request->all();
        foreach ($data as $key => $value) {

            if($key!="captcha"){
                $request[$key] = $this->descript_code($value);
            }
        }
        if(!$request->header('x-api-key')){
            return response('Unauthorized.', 401);
        }
        else{
            if($request->header('x-api-key')!='rwWjQk8TPaJAcbDqi4i9TDTXWHxQzpqzdLnM5ttKYMmYpTjLp6') {
                return response('Unauthorized.', 401);
            }else{
                return $next($request);
            }
        }
        return $next($request);
    }
/**
* Decode inputs forms.
*
* @param  $text
* @return $strReturn
*/
public function descript_code($text) {
    try {
        $key = "0123456789abcdef";
        $iv = "abcdef9876543210";
        $method = 'AES-128-CBC';
        $strData = base64_decode($text);
        $strReturn = openssl_decrypt($strData, $method, $key, OPENSSL_RAW_DATA, $iv);
        return $strReturn;
    } catch (Exception $ex) {
        return false;
    }
    return false;
}
}
