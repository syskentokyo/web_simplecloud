<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;

$validatorGet = new Valitron\Validator($_GET);

$validatorGet->rule('numeric', 'groupid');


$validatedDataID =0;

if($validatorGet->validate()) {
        if (!isset($_GET['groupid'])) {
            $validatedDataID = -999;//未選択時
        }else {
            $validatedDataID = htmlspecialchars($_GET['groupid'], ENT_QUOTES, 'UTF-8');
        }
} else {
    exit();
}







//
//
//
$groupInfoArray = CloudDBManager::SelectAllGroupInfo();
$fileInfoArray = CloudDBManager::SelectAllFileInfo();

$fileCollectionInfoArray = Array();

foreach ($fileInfoArray as $fileInfo) {

    $fileCollectionInfo = new FileCollectionInfo();
    $fileCollectionInfo->fileInfo = $fileInfo;

    $fileCollectionInfo->groupInfo = CloudDBManager::SelectFromGroupList($fileInfo->groupID);

    $fileCollectionInfoArray[]= $fileCollectionInfo;
}


//
// URL処理
//
$appBaseURL =  CURRENT_BASE_URL;
$dirArray = explode('/',$_SERVER["REQUEST_URI"]);
for($i=1;$i < (count($dirArray)-2);$i++){
    $appBaseURL= $appBaseURL."/".$dirArray[$i];
}


$fileUploadPageURL = $appBaseURL ."/".UPLOAD_FILE_DIR;

?>
<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>File List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</head>
<body>
<?php
require_once('./commonheader.php');
?>
<div  class="mx-auto"  style="width: 610px;">

    <h1>Show File List</h1>


    <h3>Select Group</h3>
    <form class="mt-5 row g-3"  enctype="multipart/form-data" method="get" action="./filelist.php">

            <select name='groupid'  id="groupid" class="form-select">
                <?php
                foreach ($groupInfoArray as $groupCollectionInfo){
                    ?>
                    <option  value="<?php echo $groupCollectionInfo->id; ?>"><?php echo $groupCollectionInfo->id ." : ". $groupCollectionInfo->groupname; ?></option>
                    <?php
                }
                ?>
            </select>


        <div class="col-12">
            <button type="submit" class="btn btn-primary">Show</button>
        </div>
    </form>

</div>


</body>
</html>







