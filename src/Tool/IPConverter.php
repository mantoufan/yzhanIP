<?php
namespace YZhanIP\Tool;
use YZhanIP\Type\IPRange;
class IPConverter {
  static public function IP2Bit(string $ip) {
    $packedChars = inet_pton($ip);
    if ($packedChars === false) return false;
    $unpackedChars = str_split($packedChars);
    $bit = '';
    foreach($unpackedChars as $unpakcedChar) {
      $bit .= str_pad(decbin(ord($unpakcedChar)), 8, '0', STR_PAD_LEFT);
    }
    return $bit;
  }
  static public function Bit2IP(string $bit) {
    $len = strlen($bit);
    $unpackedChars = '';
    for ($i = 0; $i < $len; $i += 8) {
      $unpackedChars .= chr(bindec(substr($bit, $i, 8)));
    }
    return inet_ntop($unpackedChars);
  }
  static public function IPCIDR2IPRange(string $ipCIDR): IPRange {
    $len = strpos($ipCIDR, ':') === false ? 32 : 128;
    list($ip, $mask) = explode('/', $ipCIDR);
    $mask = max(1, min($mask, $len));
    $bit = substr(self::IP2Bit($ip), 0, $mask);
    return new IPRange(
      self::Bit2IP(str_pad($bit, $len, '0', STR_PAD_RIGHT)),
      self::Bit2IP(str_pad($bit, $len, '1', STR_PAD_RIGHT))
    );
  }
}
?>