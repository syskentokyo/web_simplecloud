<?php
//
// アプリアップロード処理を行うページ
//
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;

//
// 1. パラメータチェック
//


$validatorGet = new Valitron\Validator($_POST);

$validatorGet->rule('required', ['dataid', 'setactive','groupid']);
$validatorGet->rule('numeric', 'dataid');
$validatorGet->rule('numeric', 'groupid');
$validatorGet->rule('numeric', 'setactive');


if($validatorGet->validate()) {

} else {
    exit();
}




$validatedDataID = htmlspecialchars($_POST['dataid'], ENT_QUOTES, 'UTF-8');
$validatedGroupID = htmlspecialchars($_POST['groupid'], ENT_QUOTES, 'UTF-8');
$validatedSetActive = htmlspecialchars($_POST['setactive'], ENT_QUOTES, 'UTF-8');







//
// DBを更新
//
$insertLastID = CloudDBManager::UpdatePinActive($validatedDataID,$validatedGroupID,$validatedSetActive);



//
// 完了後のページへ遷移
//
header("Location:./filelist.php?groupid=".$validatedGroupID);



