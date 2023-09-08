<?php
//
// アプリアップロード処理を行うページ
//
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use ZipArchive;


//
// 1. パラメータチェック
//

if (!isset($_FILES['uploadfile']['error']) || !is_int($_FILES['uploadfile']['error'])) {

    exit();
}

if (!isset($_POST['inputMemo1'])) {

    exit();
}

if (!isset($_POST['selectGroup'])) {

    exit();
}


$validatedMemo1 = htmlspecialchars($_POST['inputMemo1'], ENT_QUOTES, 'UTF-8');
$validatedGroupID = htmlspecialchars($_POST['selectGroup'], ENT_QUOTES, 'UTF-8');
$uploadtedFile = $_FILES['uploadfile'];
$uploadtedFileName =htmlspecialchars($_FILES['uploadfile']['name'], ENT_QUOTES, 'UTF-8');
$uploadFileExtension = pathinfo($uploadtedFileName, PATHINFO_EXTENSION);
$saveFileName = "main".".".$uploadFileExtension;



//
// 保存先作成
//
$saveTimeTxt = date("YmdHis");
$saveDirName ='public'. $saveTimeTxt;
$saveDirPath = FILE_SAVEDIR_PATH . $saveDirName;

mkdir($saveDirPath, 0766);



//
// ファイル保存
//
$saveFileBaseFilePath= $saveDirPath."/";
$saveAppFilePath= $saveFileBaseFilePath .$saveFileName;



if($saveAppFilePath!=="") {
    copy($uploadtedFile['tmp_name'], $saveAppFilePath);
}else{
    exit();
}





//
// DBへ保存
//
$insertLastID = CloudDBManager::InsertFileList($validatedGroupID,$saveDirName,$saveFileName,$validatedMemo1);




//
// 完了後のページへ遷移
//
header("Location:./");



