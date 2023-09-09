<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;

$validatorGet = new Valitron\Validator($_GET);


$validatorGet->rule('required', ['publicgroupid']);


if($validatorGet->validate()) {

} else {
    exit();
}

$validatedGroupID = htmlspecialchars($_GET['publicgroupid'], ENT_QUOTES, 'UTF-8');

$validatedDataID = null;
if (!isset($_GET['dataid'])) {
    $validatedDataID = null;
}else{
    $validatedDataID  = htmlspecialchars($_GET['dataid'], ENT_QUOTES, 'UTF-8');
}






//
//
//
$groupInfo = CloudDBManager::SelectGroupInfoByPublicID($validatedGroupID);
if($groupInfo->id < 0){
    //存在グループしないとき
    exit();
}


$targetFileInfo = null;

if($validatedDataID == null) {
    //データ指定ないとき

    //固定データ取得する
    $fileInfoFixedDataArray = CloudDBManager::SelectFileInfoPinnedOnGroup($groupInfo->id);
    if (count($fileInfoFixedDataArray) > 0) {
        //固定データあり
        $targetFileInfo = $fileInfoFixedDataArray[0];

    } else {
        //固定データなかったときの最新
        $fileInfoActiveDataArray = CloudDBManager::SelectFileInfoActiveOnlyOnGroup($groupInfo->id);
        if (count($fileInfoActiveDataArray) > 0) {
            //データあり
            $targetFileInfo = $fileInfoActiveDataArray[0];
        } else {
            //該当データなし

            exit();
        }

    }

}else{
    //指定データ取得
    $fileInfoActiveDataArray = CloudDBManager::SelectOneFileInfoActiveOnlyOnGroup($groupInfo->id,$validatedDataID);
    if (count($fileInfoActiveDataArray) > 0) {
        //データあり
        $targetFileInfo = $fileInfoActiveDataArray[0];
    } else {
        //該当データなし
        exit();
    }

}


//
// URL処理
//
$appBaseURL =  CURRENT_BASE_URL;
$dirArray = explode('/',$_SERVER["REQUEST_URI"]);
for($i=1;$i < (count($dirArray)-2);$i++){
    $appBaseURL= $appBaseURL."/".$dirArray[$i];
}


$fileBaseURL = $appBaseURL ."/".FILE_SAVEDIR;


//
// データ参照整理
//
$targetFileURL = $fileBaseURL . "" . $targetFileInfo->savedirname . "/" . $targetFileInfo->savefilename;

$targetFilePath = "../".FILE_SAVEDIR."" . $targetFileInfo->savedirname . "/" . $targetFileInfo->savefilename;


header("Content-Type: application/json; charset=utf-8");

class URLInfo{
    public $fileURL="";
}
$fileURLInfo = new URLInfo();
$fileURLInfo->fileURL = $targetFileURL;

echo json_encode($fileURLInfo,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);