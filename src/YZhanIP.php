<?php
namespace YZhanIP;
use YZhanIP\Tool\IPParser;
class YZhanIP {
  private $ips = array();
  private function _parse($raws) {
    $ips = array();
    if (gettype($raws) === 'array') {
      foreach($raws as $raw) {
        $ips []= IPParser::Parse($raw);
      }
    } else { 
      $ips []= IPParser::Parse($raws);
    }
    return $ips;
  }
  public function __construct($raws) {
    $this->ips = $this->_parse($raws);
  }
  public function __toString() {
    return implode(',', array_map(function($ip) {
      return $ip->__toString();
    }, $this->ips));
  } 
  public function toString() {
    return $this->__toString();
  }
  public function toRaw() {
    return implode(',', array_map(function($ip) {
      return $ip->toRaw();
    }, $this->ips));
  }
  public function getIPs() {
    return $this->ips;
  }
  public function in($yzhanIP) {
    $cips = $yzhanIP instanceof YZhanIP ? $yzhanIP->getIPs() : $this->_parse($yzhanIP);
    foreach($this->ips as $ip) {
      foreach($cips as $cip) {
        if ($ip->in($cip)) return true;
      }
      return false;
    }
    return true;
  }
  public function filter($yzhanIP) {
    $cips = $yzhanIP instanceof YZhanIP ? $yzhanIP->getIPs() : $this->_parse($yzhanIP);
    for($i = count($this->ips); $i--;) {
      $ip = $this->ips[$i];
      foreach($cips as $cip) {
        if ($ip->in($cip)) continue 2;
      }
      array_splice($this->ips, $i, 1);
    }
    return $this;
  }
}
?>