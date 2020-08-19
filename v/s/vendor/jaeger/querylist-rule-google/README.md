# QueryList-Rule-Google
QueryList Plugin: Google searcher.

QueryList插件：谷歌搜索引擎

## Installation for QueryList4
```
composer require jaeger/querylist-rule-google
```

## API
- Google **google($pageNumber = 10)**:get Google Searcher.

class **Google**:
- Google **search($keyword)**:set search keyword.
- Google **setHttpOpt(array $httpOpt = [])**：Set the http option,see: [GuzzleHttp options](http://docs.guzzlephp.org/en/stable/request-options.html)
- int **getCount()**:Get the total number of search results.
- int **getCountPage()**:Get the total number of pages.
- Collection **page($page = 1)**:Get search results

## Usage
- Installation Plugin

```php
use QL\QueryList;
use QL\Ext\Google;

$ql = QueryList::getInstance();
$ql->use(Google::class);
//or Custom function name
$ql->use(Google::class,'google');
```
- Example-1

```
$google = $ql->google(10)
$searcher = $google->search('QueryList');
$count = $searcher->getCount();
$data = $searcher->page(1);
$data = $searcher->page(2);

$searcher = $google->search('php');
$countPage = $searcher->getCountPage();
for ($page = 1; $page <= $countPage; $page++)
{
    $data = $searcher->page($page);
}
```

- Example-2

```
$searcher = $ql->google()->search('QueryList');
$data = $searcher->setHttpOpt([
    // Set the http proxy
    'proxy' => 'http://222.141.11.17:8118',
   // Set the timeout time in seconds
    'timeout' => 30,
])->page(1);
print_r($data->all());
```

- Example-3

```
$data= $searcher = $ql->google(3)->search('QueryList')->page(1);
print_r($data->all());
```
Out:

```
Array
(
    [0] => Array
        (
            [title] => Angular - QueryList
            [link] => https://angular.io/api/core/QueryList
        )
    [1] => Array
        (
            [title] => QueryList | @angular/core - Angularリファレンス - Web Creative Park
            [link] => http://www.webcreativepark.net/angular/querylist/
        )
    [2] => Array
        (
            [title] => Understanding ViewChildren, ContentChildren, and QueryList in ...
            [link] => https://netbasal.com/understanding-viewchildren-contentchildren-and-querylist-in-angular-896b0c689f6e
        )

)

```

