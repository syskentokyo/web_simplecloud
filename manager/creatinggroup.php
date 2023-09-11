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

$validatorGet->rule('required', ['inputGroup']);

if($validatorGet->validate()) {

} else {
    exit();
}



$validatedMemo1 = "";
$validatedGroupName = htmlspecialchars($_POST['inputGroup'], ENT_QUOTES, 'UTF-8');




//
// DBへ保存
//
$insertLastID = CloudDBManager::InsertGroupList($validatedGroupName,$validatedMemo1);




//
// 完了後のページへ遷移
//
header("Location:./grouplist.php");



