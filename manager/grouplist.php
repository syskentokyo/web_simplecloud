<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;

$validatorGet = new Valitron\Validator($_GET);




//
//
//
$groupInfoArray = CloudDBManager::SelectAllGroupInfo();


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


    <title>Group List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</head>
<body>
<?php
require_once('./commonheader.php');
?>
<div  class="mx-auto"  style="width: 610px;">

    <h1 class="mt-5">Group List</h1>




    <div class="mt-5 row g-3">

        <h3>List</h3>

        <?php
        foreach ($groupInfoArray as $groupCollectionInfo){
            ?>
            <div class="row g-3 border">
                <h4>#<?php echo $groupCollectionInfo->id;  ?></h4>
                <h5> <?php echo $groupCollectionInfo->groupname;  ?></h5>
                <div class="col-12">
                    <a class="btn btn-outline-success me-2" href="<?php echo $fileUploadPageURL."?dataid=".$groupCollectionInfo->id;  ?>" target="_blank">Upload File</a>
                </div>


                <div class="col-12">
                    <label>Public ID</label>
                    <div class="input-group">
                        <?php echo $groupCollectionInfo->publicid."<br>";  ?>
                    </div>
                </div>


                <div class="col-12">
                    <label>Memo</label>
                    <div class="input-group">
                        <?php echo $groupCollectionInfo->memo1."<br>";  ?>
                    </div>
                </div>

                <div class="col-12">
                    <label>Create Time</label>
                    <div class="input-group">
                        <?php echo $groupCollectionInfo->createtime."<br>";  ?>
                    </div>
                </div>
            </div>




            <?php
        }
        ?>

    </div>



</div>

</body>
</html>







