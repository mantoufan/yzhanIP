<?php
namespace YZhanIP\Tool;
use YZhanIP\Tool\IPParser;
class IPCrawler {
  private $url = '';
  private $options = array();
  private $path = '';
  public function __construct(string $url, $options = array()) {
    $this->url = $url;
    $this->options = array_merge(array(
      'cacheDir' => sys_get_temp_dir(),
      'cacheKey' => 'yzhanip' . md5($url),
      'cacheMaxAge' => 86400,
      'timeOut' => 6,
    ), $options);
    $this->path = $this->options['cacheDir'] . '/' . $this->options['cacheKey'] . '.php';
  }
  public function get(): array {
    if (is_file($this->path) === false || time() - filemtime($this->path) > $this->options['cacheMaxAge']) {
      $this->update();
    }
    return is_file($this->path) ? include $this->path : null;
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
    file_put_contents($this->path, '<?php return ' . var_export(IPParser::MatchAll(curl_exec($ch)), true) . ';?>');
    curl_close($ch);
  }
  public function getUrl(): string {
    return $this->url;
  }
  public function getOptions(): array {
    return $this->options;
  }
  public function getPath(): string {
    return $this->path;
  }
}
?>