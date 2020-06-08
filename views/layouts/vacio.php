<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;
// $user_id =Yii::$app->user->id;
// $user = User::find($user_id);
// var_dump(array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
// var_dump(in_array('secretaria', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))));

 function isRol($rol){
    $user_id =Yii::$app->user->id;
    return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
}
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode( Yii::$app->params['title'] ) ?></title>
    <link rel="icon" href="<?= Url::to('@web/favicon.ico') ?>">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
        <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
