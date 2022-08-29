<?php
namespace YZhanIP\Tool;
use YZhanIP\Type\Primitive;
use YZhanIP\Model\IP;
use YZhanIP\Exception\IPParserException;
use YZhanIP\Tool\IPConverter;
class IPParser {
  const IPV4 = "/(?<!\-)\b((25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(\.|\b(?![\/\-]))){4}/";
  const IPV4CIDR = "/\b((25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(\.|\/)){4}(3[0-2]|[1-2]\d|\d)\b/";
  const IPV4INTERVAL = "/\b(((25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d|\*)(\.|\b(?![\/]))){4}(-\b|\b)){2}/";
  const IPV4WILDCARD = "/(?<!\-)\b(?=[\d.]*\*)((25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d|\*)(\.|\b(?![\/\-\*])|(?<=\*))){4}/";
  const IPV6 = "/(?<!\-)\b(([\da-zA-Z]{1,4}(:|\b(?![\-]))){8}|(?<!:)(?=[\da-zA-Z:]*::)(?!([\da-zA-Z:]*::){2})([\da-zA-Z]{1,4}((::|:(?!:)|\b))){1,8})(?![-\/\da-zA-Z:])\b/";
  const IPV6CIDR = "/(?<!\-)\b(([\da-zA-Z]{1,4}(:|\b(?![\-]))){8}|(?<!:)(?=[\da-zA-Z:]*::)(?!([\da-zA-Z:]*::){2})([\da-zA-Z]{1,4}((::|:(?!:)|\b))){1,8})\/(1[0-2][0-8]|[1-9][\d]|[1-9])\b/";
  const IPV6INTERVAL = "/\b((([\da-zA-Z]{1,4}(:|\b)){8}|(?<!:)(?=[\da-zA-Z:]*::)(?!([\da-zA-Z:]*::){2}.*-)([\da-zA-Z]{1,4}((::|:(?!:)|\b))){1,8})(\-\b|\b)){2}/";
  const IPV6WILDCARD = "/(?<!\-)(?=[\da-zA-Z:]*\*)\b((([\da-zA-Z]{1,4}|(?<=:)\*(?=:))(:|\b(?![\/\-]))){8}|(?<!:)(?=[\da-zA-Z:*]*::)(?!([\da-zA-Z:*]*::){2})(([\da-zA-Z]{1,4}|(?<=:)\*(?=:))((::|:(?!:)|\b))){1,8}(?![\da-zA-Z:]*[\*\/]))/";
  static public function IsIPv4(string $raw): bool {
    return preg_match(self::IPV4, $raw) > 0;
  }
  static public function IsIPv4CIDR(string $raw): bool {
    return preg_match(self::IPV4CIDR, $raw) > 0;
  }
  static public function IsIPv4Interval(string $raw): bool {
    return preg_match(self::IPV4INTERVAL, $raw) > 0;
  }
  static public function IsIPv4Wildcard(string $raw): bool {
    return preg_match(self::IPV4WILDCARD, $raw) > 0;
  }
  static public function IsIPv6(string $raw): bool {
    return preg_match(self::IPV6, $raw) > 0;
  }
  static public function IsIPv6CIDR(string $raw): bool {
    return preg_match(self::IPV6CIDR, $raw) > 0;
  }
  static public function IsIPv6Interval(string $raw): bool {
    return preg_match(self::IPV6INTERVAL, $raw) > 0;
  }
  static public function IsIPv6Wildcard(string $raw): bool {
    return preg_match(self::IPV6WILDCARD, $raw) > 0;
  }
  static public function IsIP(string $raw): bool {
    return self::IsIPv4($raw) || self::IsIPv6($raw);
  }
  static public function IsIPCIDR(string $raw): bool {
    return self::IsIPv4CIDR($raw) || self::IsIPv6CIDR($raw);
  }
  static public function IsIPInterval(string $raw): bool {
    return self::IsIPv4Interval($raw) || self::IsIPv6Interval($raw);
  }
  static public function IsIPWildcard(string $raw): bool {
    return self::IsIPv4Wildcard($raw) || self::IsIPv6Wildcard($raw);
  }
  static public function IsIPRange(string $raw): bool {
    return self::IsIPCIDR($raw) || self::IsIPInterval($raw) || self::IsIPWildcard($raw);
  }
  static public function GetType(string $raw): string {
    if (strpos($raw, ':') === false) {
      if (self::IsIPv4($raw)) return Primitive::IPV4;
      elseif (strpos($raw, '/') !== false && self::IsIPv4CIDR($raw)) return Primitive::IPV4CIDR;
      elseif (strpos($raw, '-') !== false && self::IsIPv4Interval($raw)) return Primitive::IPV4INTERVAL;
      elseif (strpos($raw, '*') !== false && self::IsIPv4Wildcard($raw)) return Primitive::IPV4WILDCARD;
    } else {
      if (self::IsIPv6($raw)) return Primitive::IPV6;
      elseif (strpos($raw, '/') !== false && self::IsIPv6CIDR($raw)) return Primitive::IPV6CIDR;
      elseif (strpos($raw, '-') !== false && self::IsIPv6Interval($raw)) return Primitive::IPV6INTERVAL;
      elseif (strpos($raw, '*') !== false && self::IsIPv6Wildcard($raw)) return Primitive::IPV6WILDCARD;
    }
    throw new IPParserException('Unrecognized type of' . $raw);
  }
  static public function Parse(string $raw): IP {
    $type = self::GetType($raw);
    if ($type === Primitive::IPV4 || $type === Primitive::IPV6) {
      $first = $raw;
      $last = null;
    } elseif ($type === Primitive::IPV4CIDR || $type === Primitive::IPV6CIDR) {
      $ipRange = IPConverter::IPCIDR2IPRange($raw);
      $first = $ipRange->getFirst();
      $last = $ipRange->getLast();
    } elseif ($type === Primitive::IPV4INTERVAL || $type === Primitive::IPV6INTERVAL) {
      list($first, $last) = explode('-', $raw);
    } elseif ($type === Primitive::IPV4WILDCARD || $type === Primitive::IPV6WILDCARD) {
      $first = str_replace('*', '0', $raw);
      $last = str_replace('*', $type === Primitive::IPV4WILDCARD ? '255' : 'ffff', $raw);
    }
    $start = inet_pton($first);
    $end = $last == null ? null : inet_pton($last);
    return new IP($start, $end, $type, $raw);
  }
  static private function _matchAll(string $content, string $rule) {
    preg_match_all($rule, $content, $matches);
    return $matches[0];
  }
  static public function MatchAllIPv4(string $content) {
    return self::_matchAll($content, self::IPV4);
  }
  static public function MatchAllIPv4CIDR(string $content) {
    return self::_matchAll($content, self::IPV4CIDR);
  }
  static public function MatchAllIPv4Interval(string $content) {
    return self::_matchAll($content, self::IPV4INTERVAL);
  }
  static public function MatchAllIPv4Wildcard(string $content) {
    return self::_matchAll($content, self::IPV4WILDCARD);
  }
  static public function MatchAllIPv6(string $content) {
    return self::_matchAll($content, self::IPV6);
  }
  static public function MatchAllIPv6CIDR(string $content) {
    return self::_matchAll($content, self::IPV6CIDR);
  }
  static public function MatchAllIPv6Interval(string $content) {
    return self::_matchAll($content, self::IPV6INTERVAL);
  }
  static public function MatchAllIPv6Wildcard(string $content) {
    return self::_matchAll($content, self::IPV6WILDCARD);
  }
  static private function _merge(...$ar) {
    $r = array_merge(...array_filter($ar));
    return count($r) === 0 ? null : $r;
  }
  static public function MatchAllIP(string $content) {
    return self::_merge(self::MatchAllIPv4($content), self::MatchAllIPv6($content));
  }
  static public function MatchAllIPCIDR(string $content) {
    return self::_merge(self::MatchAllIPv4CIDR($content), self::MatchAllIPv6CIDR($content));
  }
  static public function MatchAllIPInterval(string $content) {
    return self::_merge(self::MatchAllIPv4Interval($content), self::MatchAllIPv6Interval($content));
  }
  static public function MatchAllIPWildcard(string $content) {
    return self::_merge(self::MatchAllIPv4Wildcard($content), self::MatchAllIPv6Wildcard($content));
  }
  static public function MatchAll(string $content) {
    return self::_merge(self::MatchAllIP($content), self::MatchAllIPCIDR($content), self::MatchAllIPInterval($content), self::MatchAllIPWildcard($content));
  }
}
?>