<?php

namespace frontend\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class SLinkPager extends \yii\widgets\LinkPager
{

    public $prevPageLabel      = '<';
    public $nextPageLabel      = '>';
    public $firstPageLabel     = false;
    public $lastPageLabel      = false;
    public $activePageCssClass = "active";
    public $firstPageCssClass  = 'list_link';
    public $prevPageCssClass   = 'list_link prev';
    public $nextPageCssClass   = 'list_link next';
    public $lastPageCssClass   = 'list_link';

    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();
        
        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false, false, true);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false, false, true);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        
        if($beginPage != 0) {
            $buttons[] = $this->renderPageButton('...', null, 'list_link' , false, false, true);
        } 
        
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, 'list_link', false, $i == $currentPage);
        }

        if($endPage != $pageCount-1) {
            $buttons[] = $this->renderPageButton('...', null, 'list_link', false, false,true);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false, false, true);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false, false, true);
        }

        // buttons wrapper
        $custom_buttons = [];
        foreach($buttons as $key => $button){
                if(strstr($button,'active')!==false)
                {
                    $custom_buttons[] = "<li class='list_item active'>".$button."</li>";

                }
                else
                {
                    $custom_buttons[] = "<li class='list_item'>".$button."</li>";

                }

        }
        return Html::tag('ul', implode("\n", $custom_buttons), $this->options);
    }
    
    protected function renderPageButton($label, $page, $class, $disabled, $active, $span = false,$pn = false)
    {
        ++$page; // потому что отсчет страниц начинается с нуля
        $options = ['class' => ($class === 'active ' ? null : $class)];
        
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
            return Html::tag('a', $label,$options);
        }
        
        if ($disabled) 
        {
            $options['class'] = 'list_link';
            return Html::tag('a', $label,$options);
        }
        
        if ($span) {
            return Html::tag('span', $label,$options);
        }
        
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        $linkOptions['class'] = 'list_link ';
        if($pn){
            $linkOptions['class'] .= " {$class}";
        }
        
        $request_uri = Yii::$app->request->url;
        
        // если это первая страница, тогда в ссылке не генерится /page/1. часть SEO-оптимизации
        if($page == 1)
        {
            $current = $this->pagination->getPage() + 1;
            $request_uri = str_replace('/page/'.$current, '', $request_uri);
            return  Html::a($label,  $request_uri, $linkOptions);    
        }

        if(!preg_match('#(/page/)\d#', $request_uri))
        {
            return  Html::a($label,  $request_uri.'/page/'.$page, $linkOptions);    
        }
        
        $url_string = preg_replace('#(/page/)\d#', '/page/'.$page, $request_uri);
        return Html::a($label, $url_string, $linkOptions);    
    }
    
    /**
     * Creates the URL suitable for pagination with the specified page number.
     * This method is mainly called by pagers when creating URLs used to perform pagination.
     * @param integer $page the zero-based page number that the URL should point to.
     * @param integer $pageSize the number of items on each page. If not set, the value of [[pageSize]] will be used.
     * @param boolean $absolute whether to create an absolute URL. Defaults to `false`.
     * @return string the created URL
     * @see params
     * @see forcePageParam
     */
    public function createUrl($page, $pageSize = null, $absolute = false)
    {
        $page = (int) $page;
        $pageSize = (int) $pageSize;
//        $request = Yii::$app->request;
//        if (($params = Yii::app()->request->getParams() ) === null) {
//            $request = Yii::$app->getRequest();
            $params = Yii::$app->request->getQueryParams();
//        }
        if ($page > 0 || $page >= 0 && $this->pagination->forcePageParam) {
            $params[$this->pagination->pageParam] = $page + 1;
        } else {
            unset($params[$this->pagination->pageParam]);
        }
        if ($pageSize <= 0) {
            $pageSize = $this->pagination->getPageSize();
        }
        if ($pageSize != $this->pagination->defaultPageSize) {
            $params[$this->pagination->pageSizeParam] = $pageSize;
        } else {
            unset($params[$this->pagination->pageSizeParam]);
        }
        $params[0] = $this->pagination->route === null ? Yii::$app->controller->getRoute() : $this->route;
        $urlManager = Yii::$app->getUrlManager();

        if ($absolute) {
            return $urlManager->createAbsoluteUrl($params);
        } else {
            return $urlManager->createUrl($params);
        }
    }
}