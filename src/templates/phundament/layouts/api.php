<?php

use yii\apidoc\templates\bootstrap\ApiRenderer;
use yii\apidoc\templates\bootstrap\SideNavWidget;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $types array */
/* @var $content string */

/** @var $renderer ApiRenderer */
$renderer = $this->context;

$this->beginContent('@app/templates/apidoc/layouts/main.php', isset($type) ? ['type' => $type] : []); ?>

<div class="row">
    <div class="col-md-3 text-small">
        <?php
        $types = $renderer->getNavTypes(isset($type) ? $type : null, $types);
        ksort($types);
        $nav = [];
        $subNav = [];
        foreach ($types as $i => $class) {
            $namespace = $class->namespace;
            preg_match('/^([a-zA-Z0-9]+\\\[a-zA-Z0-9]*)/',$class->namespace,$matches);
            #var_dump($class->namespace,$matches);
            if (isset($matches[1])) {
                $namespace = $matches[1];
            } else {
                $namespace = '';
            }

            $subNamespace = StringHelper::dirname($class->name);
            $subLabel = StringHelper::dirname(str_replace($namespace,'',$class->name));
            if (empty($subNamespace)) {
                $subNamespace = $class->namespace;
                $subLabel = '.';
            }
            if (empty($namespace)) {
                $namespace = 'Not namespaced classes';
            }

            if (!isset($nav[$namespace])) {
                $nav[$namespace] = [
                    'label' => $namespace,
                    'url' => '#',
                    #'items' => &$subNav[$label],
                ];
            }
            if (!isset($subNav[$subNamespace])) {
                $subNav[$subNamespace] = [
                    'label' => $subLabel,
                    'url' => '#',
                    #'active' => isset($type) && ($class->name == $type->name),
                    'items' => [],
                ];
                $nav[$namespace]['items'][] = &$subNav[$subNamespace];
            }

            $subNav[$subNamespace]['items'][] = [
                'label' => StringHelper::basename($class->name),
                'url' => './' . $renderer->generateApiUrl($class->name),
                'active' => isset($type) && ($class->name == $type->name),
            ];

            if (isset($type) && ($class->name == $type->name)) {
                $subNav[$subNamespace]['active'] = true;
            }
        } ?>
        <?= SideNavWidget::widget([
            'id' => 'navigation',
            'items' => $nav,
            'view' => $this,
        ])?>
    </div>
    <div class="col-md-9 api-content" role="main">
        <?= $content ?>
    </div>
</div>

<script type="text/javascript">
    /*<![CDATA[*/
    $("a.toggle").on('click', function () {
        var $this = $(this);
        if ($this.hasClass('properties-hidden')) {
            $this.text($this.text().replace(/Show/,'Hide'));
            $this.parents(".summary").find(".inherited").show();
            $this.removeClass('properties-hidden');
        } else {
            $this.text($this.text().replace(/Hide/,'Show'));
            $this.parents(".summary").find(".inherited").hide();
            $this.addClass('properties-hidden');
        }

        return false;
    });
    /*
     $(".sourceCode a.show").toggle(function () {
     $(this).text($(this).text().replace(/show/,'hide'));
     $(this).parents(".sourceCode").find("div.code").show();
     },function () {
     $(this).text($(this).text().replace(/hide/,'show'));
     $(this).parents(".sourceCode").find("div.code").hide();
     });
     $("a.sourceLink").click(function () {
     $(this).attr('target','_blank');
     });
     */
    /*]]>*/
</script>

<?php $this->endContent(); ?>
