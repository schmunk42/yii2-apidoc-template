Documentation template for Phundament 4.0
=========================================
Application documentation and guide

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist schmunk42/yii2-apidoc-template "*"
```

or add

```
"schmunk42/yii2-apidoc-template": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \schmunk42\apidoc\AutoloadExample::widget(); ?>```