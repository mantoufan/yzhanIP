<?php
/**
 * Created by PhpStorm.
 * User: Jaeger <JaegerCode@gmail.com>
 * Date: 2017/10/1
 * Baidu searcher
 */

namespace QL\Ext;

use QL\Contracts\PluginContract;
use QL\QueryList;

class Google implements PluginContract
{
    protected $ql;
    protected $keyword;
    protected $pageNumber = 10;
    protected $httpOpt = [];
    const API = 'https://ipv6.google.com/search';
    const RULES = [
      'title' => ['h3','text'],
      'link' => ['a','href']
    ];
    const RANGE = '.g';

    public function __construct(QueryList $ql, $pageNumber)
    {
        $this->ql = $ql->rules(self::RULES)->range(self::RANGE);
        $this->pageNumber = $pageNumber;
    }

    public static function install(QueryList $queryList, ...$opt)
    {
        $name = $opt[0] ?? 'google';
        $queryList->bind($name,function ($pageNumber = 10){
            return new Google($this,$pageNumber);
        });
    }

    public function setHttpOpt(array $httpOpt = [])
    {
        $this->httpOpt = $httpOpt;
        return $this;
    }

    public function search($keyword)
    {
        $this->keyword = $keyword;
        return $this;
    }

    public function page($page = 1)
    {
        return $this->query($page)->query()->getData();
    }

    public function getCount()
    {
        $count = 0;
        $text =  $this->query(1)->find('#resultStats')->text();
        if(preg_match('/[\d,]+/',$text,$arr))
        {
            $count = str_replace(',','',$arr[0]);
        }
        return (int)$count;
    }

    public function getCountPage()
    {
        $count = $this->getCount();
        $countPage = ceil($count / $this->pageNumber);
        return $countPage;
    }

    protected function query($page = 1)
    {
        $this->ql->get(self::API,[
            'q' => $this->keyword,
            'num' => $this->pageNumber,
            'start' => $this->pageNumber * ($page-1),
            'tbs' => 'qdr:1,sbd:1'
        ],$this->httpOpt);
        return $this->ql;
    }

}