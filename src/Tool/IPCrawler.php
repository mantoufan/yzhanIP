<?php
namespace YZhanIP\Tool;
use YZhanIP\Tool\IPParser;
use YZhanCache\YZhanCache;
class IPCrawler {
  private $url = '';
  private $options = array();
  private $yzhanCache;
  public function __construct(string $url, $options = array()) {
    $this->url = $url;
    $this->options = array_merge(array(
      'cacheDir' => sys_get_temp_dir(),
      'cacheKey' => 'yzhanip' . md5($url),
      'cacheMaxAge' => 86400,
      'timeOut' => 6,
    ), $options);
    $this->yzhanCache = new YZhanCache('File', array(
      'dir' => $this->options['cacheDir']
    ));
  }
  public function get(): array {
    if ($this->yzhanCache->has($this->options['cacheKey']) === false) {
      $this->update();
    }
    return $this->yzhanCache->get($this->options['cacheKey']);
  }
  public function update(): void {
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->url,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_TIMEOUT => $this->options['timeOut'],
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
    ));
    $this->yzhanCache->set($this->options['cacheKey'], IPParser::MatchAll(curl_exec($ch)), $this->options['cacheMaxAge']);
    curl_close($ch);
  }
  public function getUrl(): string {
    return $this->url;
  }
  public function getOptions(): array {
    return $this->options;
  }
  public function clearCache() {
    return $this->yzhanCache->clear();
  }
}
?>