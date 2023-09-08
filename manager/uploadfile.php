<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;

$validatorGet = new Valitron\Validator($_GET);

$validatorGet->rule('required', ['dataid']);
$validatorGet->rule('numeric', 'dataid');

if($validatorGet->validate()) {

} else {
    exit();
}

$validatedDataID = htmlspecialchars($_GET['dataid'], ENT_QUOTES, 'UTF-8');




$groupInfoArray = CloudDBManager::SelectAllGroupInfo();



$targetGroupInfo =null;

foreach ($groupInfoArray as $groupInfo){
    if($groupInfo->id == $validatedDataID){
        $targetGroupInfo=$groupInfo;
    }
}

if($targetGroupInfo==null){
    exit();
}


?>
<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Upload File</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</head>
<body>
<?php
require_once('./commonheader.php');
?>
<div  class="mx-auto"  style="width: 610px;">

<h1 class="m-1 mt-5">Upload App File</h1>


<form class="mt-5 row g-3"  enctype="multipart/form-data" method="post" action="uploadingfile.php">

    <div class="col-12">
        <label for="inputFile" class="form-label">File</label>
        <div class="input-group">
            <input type="file" class="form-control" id="inputFile" name="uploadfile">
        </div>
    </div>

    <div class="col-12">
        <label for="selectGroup" class="form-label">Group</label>
        <div class="input-group">
            <?php echo $targetGroupInfo->id." : ".$targetGroupInfo->groupname ;?>
            <input type="hidden" class="form-control" id="selectGroup"  name="selectGroup" value="<?php echo $targetGroupInfo->id; ?>" />
        </div>


    </div>

    <div class="col-12">
        <label for="inputMemo1" class="form-label">Memo</label>
        <textarea name='inputMemo1' class="form-control" id="inputMemo1" placeholder="Bugfix..."></textarea>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Upload</button>
    </div>
</form>



</div>

</body>
</html>




