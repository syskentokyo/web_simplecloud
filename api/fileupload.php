<?php
//
// アプリアップロード処理を行うページ
//
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Ramsey\Uuid\Uuid;
use ZipArchive;
use Valitron;

//
// 1. パラメータチェック
//

if (!isset($_FILES['uploadfile']['error']) || !is_int($_FILES['uploadfile']['error'])) {

    exit();
}


if (!isset($_POST['publicgroupid'])) {

    exit();
}


$validatedPublicGroupID = htmlspecialchars($_POST['publicgroupid'], ENT_QUOTES, 'UTF-8');
$uploadtedFile = $_FILES['uploadfile'];
$uploadtedFileName =htmlspecialchars($_FILES['uploadfile']['name'], ENT_QUOTES, 'UTF-8');
$uploadFileExtension = pathinfo($uploadtedFileName, PATHINFO_EXTENSION);
$saveFileName = "mainapi".".".$uploadFileExtension;



//
// グループの存在チェック
//

if(CloudDBManager::IsExitGroupOnGroupList($validatedPublicGroupID)===false){
    //グループが存在しないとき
    exit();
}


$groupInfo = CloudDBManager::SelectPublicGroupIDFromGroupList($validatedPublicGroupID);




//
// 保存先作成
//
$uuidTxt =Uuid::uuid4()->toString();
$validUuidTxt=  str_replace("-","",$uuidTxt);//UUIDをつかって同じフォルダがつくられないようにする
$saveTimeTxt = date("YmdHis");
$saveDirName ='public'. $saveTimeTxt.$validUuidTxt;
$saveDirPath = FILE_SAVEDIR_PATH . $saveDirName;

mkdir($saveDirPath, 0766);



//
// ファイル保存
//
$saveFileBaseFilePath= $saveDirPath."/";
$saveAppFilePath= $saveFileBaseFilePath .$saveFileName;



if($saveAppFilePath!=="") {
    if(!move_uploaded_file($uploadtedFile['tmp_name'], $saveAppFilePath)){
        //失敗時
        exit();
    }

    chmod($saveAppFilePath, 0644);

}else{
    exit();
}





//
// DBへ保存
//
$insertLastID = CloudDBManager::InsertFileListWithActive($groupInfo->id,$saveDirName,$saveFileName,"");


header("Content-Type: application/json; charset=utf-8");

class UploadFileInfo{
    public $publicgroupid="";
    public $dataid=-999;
}
$uploadFileInfo = new UploadFileInfo();
$uploadFileInfo->publicgroupid = $validatedPublicGroupID;
$uploadFileInfo->dataid = $insertLastID;

echo json_encode($uploadFileInfo,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);





