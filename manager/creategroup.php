<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');

use Valitron;


?>
<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>CreateGroup</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</head>
<body>
<?php
require_once('./commonheader.php');
?>
<div  class="mx-auto"  style="width: 610px;">

    <h1 class="m-1 mt-5">CreateGroup</h1>


    <form class="mt-5 row g-3"  enctype="multipart/form-data" method="post" action="creatinggroup.php">

        <div class="col-12">
            <label for="inputGroup" class="form-label">Group Name</label>
            <textarea name='inputGroup' class="form-control" id="inputGroup" placeholder=""></textarea>
        </div>




        <div class="col-12">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>



</div>

</body>
</html>




