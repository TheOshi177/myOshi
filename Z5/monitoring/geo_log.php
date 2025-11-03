<?php
require_once '../session_config.php';
require_once '../connect.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    http_response_code(403); exit("Brak dostępu");
}

$username = $_SESSION['username'];

function ip_details($ip) {
    $json = @file_get_contents("http://ipinfo.io/{$ip}/geo");
    if(!$json) return null;
    return json_decode($json,true);
}

function getBrowserAndOS($user_agent) {
    $browser = "Inna"; $version = ""; $os = "Nieznany system";
    if(preg_match('/Windows NT 10.0/i',$user_agent)) $os="Windows 10";
    elseif(preg_match('/Windows NT 11.0/i',$user_agent)) $os="Windows 11";
    elseif(preg_match('/Windows NT 6.3/i',$user_agent)) $os="Windows 8.1";
    elseif(preg_match('/Windows NT 6.1/i',$user_agent)) $os="Windows 7";
    elseif(preg_match('/Macintosh|Mac OS X/i',$user_agent)) $os="macOS";
    elseif(preg_match('/Linux/i',$user_agent)) $os="Linux";
    elseif(preg_match('/Android/i',$user_agent)) $os="Android";
    elseif(preg_match('/iPhone|iPad|iPod/i',$user_agent)) $os="iOS";
    if(strpos($user_agent,'OPR')!==false){$browser='Opera';preg_match('/OPR\/([0-9\.]+)/',$user_agent,$m);$version=$m[1]??'';}
    elseif(strpos($user_agent,'Edg')!==false){$browser='Edge';preg_match('/Edg\/([0-9\.]+)/',$user_agent,$m);$version=$m[1]??'';}
    elseif(strpos($user_agent,'Chrome')!==false){$browser='Chrome';preg_match('/Chrome\/([0-9\.]+)/',$user_agent,$m);$version=$m[1]??'';}
    elseif(strpos($user_agent,'Firefox')!==false){$browser='Firefox';preg_match('/Firefox\/([0-9\.]+)/',$user_agent,$m);$version=$m[1]??'';}
    elseif(strpos($user_agent,'Safari')!==false){$browser='Safari';preg_match('/Version\/([0-9\.]+)/',$user_agent,$m);$version=$m[1]??'';}
    return trim("$os – $browser $version");
}

$ipaddress = $_SERVER['REMOTE_ADDR'];
$details = ip_details($ipaddress);
$raw = file_get_contents('php://input');
$data = json_decode($raw,true);
if(!$details || !$data){http_response_code(400); exit("Brak danych.");}

$browser = getBrowserAndOS($_SERVER['HTTP_USER_AGENT']);
$screen_total_width  = intval($data['screenTotalWidth'] ?? 0);
$screen_total_height = intval($data['screenTotalHeight'] ?? 0);
$screen_width        = intval($data['screenWidth'] ?? 0);
$screen_height       = intval($data['screenHeight'] ?? 0);
$color_depth         = intval($data['colorDepth'] ?? 0);
$language            = substr($data['language'] ?? '',0,10);
$cookies_enabled     = !empty($data['cookiesEnabled']) ? 1 : 0;
$java_enabled        = !empty($data['javaEnabled']) ? 1 : 0;

$stmt = $pdo->prepare("INSERT INTO goscieportalu 
(ipaddress, datetime, country, region, city, loc, browser,
screen_total_width, screen_total_height, screen_width, screen_height,
color_depth, language, cookies_enabled, java_enabled)
VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    $ipaddress,
    $details['country'] ?? '',
    $details['region'] ?? '',
    $details['city'] ?? '',
    $details['loc'] ?? '',
    $browser,
    $screen_total_width,
    $screen_total_height,
    $screen_width,
    $screen_height,
    $color_depth,
    $language,
    $cookies_enabled,
    $java_enabled
]);

http_response_code(200); exit("OK");
