<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;

$validatorGet = new Valitron\Validator($_GET);


$validatorGet->rule('required', ['groupid']);
$validatorGet->rule('numeric', 'groupid');


if($validatorGet->validate()) {
} else {
    exit();
}



$validatedGroupID = htmlspecialchars($_GET['groupid'], ENT_QUOTES, 'UTF-8');



//
//
//
$groupInfo = CloudDBManager::SelectGroupInfo($validatedGroupID);
$fileInfoArray = CloudDBManager::SelectFileInfoOnGroup($validatedGroupID);

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


$fileBaseURL = $appBaseURL ."/".FILE_SAVEDIR;

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

    <h1 class="mt-5">File List</h1>



    <div class="mt-5 row g-3">


        <h3>Group Info</h3>

        <div class="col-12">
            <label>Group</label>
            <div class="input-group">
                <h4>#<?php echo $groupInfo->id . "  :  " .$groupInfo->groupname ;  ?></h4>

            </div>
        </div>


        <div class="col-12">
            <label>Public ID</label>
            <div class="input-group">
                <?php echo $groupInfo->publicid."<br>";  ?>
            </div>
        </div>

        <h3>File List</h3>

        <?php
        foreach ($fileCollectionInfoArray as $fileCollectionInfo){
            ?>
            <div class="row g-3 border">
                <h4>#<?php echo $fileCollectionInfo->fileInfo->dataID;  ?></h4>

                <div class="col-6">
                    <label>Fix</label>
                    <div class="input-group">
                        <?php
                        if($fileCollectionInfo->fileInfo->ispinned===1){
                            ?>
                            <form class="col-6"  enctype="multipart/form-data" method="post" action="changingpinactive.php">
                                <input type="hidden" name="dataid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->dataID."\""; ?>>
                                <input type="hidden" name="groupid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->groupID."\""; ?>>
                                <input type="hidden" name="setactive" value=<?php echo "\""."0"."\""; ?>>
                                <button type="submit" class="btn btn-success ">Pinned</button>
                            </form>
                            <?php
                        }else{
                            ?>
                            <form class="col-6"  enctype="multipart/form-data" method="post" action="changingpinactive.php">
                                <input type="hidden" name="dataid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->dataID."\""; ?>>
                                <input type="hidden" name="groupid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->groupID."\""; ?>>
                                <input type="hidden" name="setactive" value=<?php echo "\""."1"."\""; ?>>
                                <button type="submit" class="btn btn-outline-secondary ">None</button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>


                <div class="col-6">
                    <label>Active</label>
                    <div class="input-group">
                        <?php
                        if($fileCollectionInfo->fileInfo->isactive===1){
                            ?>
                            <form class="col-6"  enctype="multipart/form-data" method="post" action="changingfileactive.php">
                                <input type="hidden" name="dataid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->dataID."\""; ?>>
                                <input type="hidden" name="groupid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->groupID."\""; ?>>
                                <input type="hidden" name="setactive" value=<?php echo "\""."0"."\""; ?>>
                                <button type="submit" class="btn btn-success ">On</button>
                            </form>
                            <?php
                        }else{
                            ?>
                            <form class="col-6"  enctype="multipart/form-data" method="post" action="changingfileactive.php">
                                <input type="hidden" name="dataid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->dataID."\""; ?>>
                                <input type="hidden" name="groupid" value=<?php echo "\"".$fileCollectionInfo->fileInfo->groupID."\""; ?>>
                                <input type="hidden" name="setactive" value=<?php echo "\""."1"."\""; ?>>
                                <button type="submit" class="btn btn-outline-secondary ">Off</button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-12">
                    <label>File Path</label>
                    <div class="input-group">
                        <?php $targetFileURL= $fileBaseURL."".$fileCollectionInfo->fileInfo->savedirname."/".$fileCollectionInfo->fileInfo->savefilename;


                        ?>
                        <a class="" href="<?php echo $targetFileURL;  ?>"><?php echo $targetFileURL;  ?></a>
                    </div>
                </div>

                <div class="col-12">
                    <label>Memo</label>
                    <div class="input-group">
                        <?php echo str_replace("\n","</br>",$fileCollectionInfo->fileInfo->memo1)."<br>";  ?>
                    </div>
                </div>

                <div class="col-12">
                    <label>Create Time</label>
                    <div class="input-group">
                        <?php echo $fileCollectionInfo->fileInfo->createtime;  ?>
                    </div>
                </div>


            </div>




            <?php
        }
        ?>

    </div>



</div>


</br>
</br>
</br>
</br>

</body>
</html>







