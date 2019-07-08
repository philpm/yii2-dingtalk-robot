yii2-dingtalk-robot
=======

使用钉钉机器人api作为yii2-log的target

## Installation

### 1. 使用composer require安装

```sh
php composer.phar require --prefer-dist philpm/yii2-dingtalk-robot "0.0.1"
```

### 2. 添加依赖到composer.json文件

```json
"philpm/yii2-dingtalk-robot": "0.0.1"
```

## Usage

```php
....
'components' => [
    'log' => [
        'targets' => [
            [
                'class' => 'phil\dingtalk\Target',
                'levels' => ['error', 'warning'],
                'categories' => ['api', 'app'],
                'except' => [
                    'yii\web\HttpException:404',
                ],
            ],
        ]
....
```
## Testing

TODO

