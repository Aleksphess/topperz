<?php
namespace frontend\widgets;
use Yii;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

class Sbreadcrumbs extends Breadcrumbs
{	
    public $tag = "ol";
    public $options = ['class' => 'b-crumb'];
    public $itemTemplate = "<li class=\"b-crumb__item\" itemscope=\"\" itemtype=\"http://data-vocabulary.org/Breadcrumb\">{link}</li>";
    public $activeItemTemplate = "<li class=\"b-crumb__item b-crumb__item_active\" itemscope=\"\" itemtype=\"http://data-vocabulary.org/Breadcrumb\">{link}</li>";
    public $encodeLabels = false;

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => "Главная ",
                'url' => Yii::$app->homeUrl,
                'itemprop' => 'url'
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }

}