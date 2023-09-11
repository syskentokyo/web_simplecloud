<?php
namespace Syskentokyo\SimpleCloud;

require_once( '../vendor/autoload.php' );


require_once('../api/common/commonrequireall.php');






//
// URL処理
//
$appBaseURL =  CURRENT_BASE_URL;
$dirArray = explode('/',$_SERVER["REQUEST_URI"]);
for($i=1;$i < (count($dirArray)-2);$i++){
    $appBaseURL= $appBaseURL."/".$dirArray[$i];
}


$fileDownloadAPIURL = $appBaseURL ."/".FILE_DOWNLOAD_API_PATH;
$fileURLAPIURL = $appBaseURL ."/".FILE_URL_API_PATH;
$fileUploadAPIURL = $appBaseURL ."/".FILE_UPLOAD_API_PATH;


?>
<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>API Documents</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</head>
<body>
<?php
require_once('./commonheader.php');
?>
<div  class="mx-auto"  style="width: 610px;">

    <h1>API Documents</h1>

    <div class="mt-5 row g-3">

        <div class="mt-4 row g-2 border">
            <h3>File Download</h3>

            <div class="col-12">
                <label>URL</label>
                <div class="input-group">
                    <?php echo $fileDownloadAPIURL; ?>
                </div>
            </div>

            <div class="col-12">
                <label>概要</label>
                <div class="input-group">
                    最新or指定ファイルデータを取得できます。
                </div>
            </div>

            <div class="col-12">
                <label>返却値</label>
                <div class="input-group">
                    ファイルデータ
                </div>
            </div>


            <div class="col-12">
                <label>METHOD</label>
                <div class="input-group">
                    GET
                </div>
            </div>

            <div class="col-12">
                <label>GET Param</label>
                <div class="input-group">
                    <ul class="list-group">
                        <li class="list-group-item">
                            publicgroupid
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">必須</li>
                                <li class="list-group-item">文字列型</li>
                                <li class="list-group-item">取得したファイルのグループの公開ID</li>
                                <li class="list-group-item">指定グループの最新or固定されたデータが返却されます。</li>
                            </ul>
                        </li>

                        <li class="list-group-item">
                            dataid
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">オプション</li>
                                <li class="list-group-item">数値型</li>
                                <li class="list-group-item">ファイルID</li>
                                <li class="list-group-item">このパラメータがあると、指定したファイルがいつも返されます</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-12">
                <label>URLサンプル</label>
                <div class="input-group">
                    http://localhost:8888/api/filedownload.php?publicgroupid=1be9dbf4e8b841a29e017649d063e9ab
                </div>
            </div>


        </div>

        <div class="mt-4 row g-2 border">

            <h3>File URL</h3>

            <div class="col-12">
                <label>URL</label>
                <div class="input-group">
                    <?php echo $fileURLAPIURL; ?>
                </div>
            </div>

            <div class="col-12">
                <label>概要</label>
                <div class="input-group">
                    最新or指定ファイルのURLを取得できます
                </div>
            </div>

            <div class="col-12">
                <label>返却値</label>
                <div class="input-group">
                    JSON形式のURL文字列
                </div>
            </div>


            <div class="col-12">
                <label>METHOD</label>
                <div class="input-group">
                    GET
                </div>
            </div>

            <div class="col-12">
                <label>GET Param</label>
                <div class="input-group">
                    <ul class="list-group">
                        <li class="list-group-item">
                            publicgroupid
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">必須</li>
                                <li class="list-group-item">文字列型</li>
                                <li class="list-group-item">取得したファイルのグループの公開ID</li>
                                <li class="list-group-item">指定グループの最新or固定されたデータが返却されます。</li>
                            </ul>
                        </li>

                        <li class="list-group-item">
                            dataid
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">オプション</li>
                                <li class="list-group-item">数値型</li>
                                <li class="list-group-item">ファイルID</li>
                                <li class="list-group-item">このパラメータがあると、指定したファイルがいつも返されます</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="col-12">
                <label>URLサンプル</label>
                <div class="input-group">
                    http://localhost:8888/api/fileurl.php?publicgroupid=1be9dbf4e8b841a29e017649d063e9ab&dataid=12
                </div>
            </div>

            <div class="col-12">
                <label>返却値サンプル</label>
                <div class="input-group">
                    <code>
                        {
                        "fileURL": "http://localhost:8888/api/savedata/publicfile/public20230908202133/main.log"
                        }

                    </code>
                </div>
            </div>

        </div>


        <div class="mt-4 row g-2 border">

            <h3>File Upload</h3>

            <div class="col-12">
                <label>URL</label>
                <div class="input-group">
                    <?php echo $fileUploadAPIURL; ?>
                </div>
            </div>

            <div class="col-12">
                <label>概要</label>
                <div class="input-group">
                    グループを指定してファイルをアップロードできます
                </div>
            </div>

            <div class="col-12">
                <label>返却値</label>
                <div class="input-group">
                    JSON形式のURL文字列
                </div>
            </div>


            <div class="col-12">
                <label>METHOD</label>
                <div class="input-group">
                    POST
                </div>
            </div>

            <div class="col-12">
                <label>POST Param</label>
                <div class="input-group">
                    <ul class="list-group">
                        <li class="list-group-item">
                            publicgroupid
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">必須</li>
                                <li class="list-group-item">文字列型</li>
                                <li class="list-group-item">取得したファイルのグループの公開ID</li>
                                <li class="list-group-item">グループを指定します</li>
                            </ul>
                        </li>

                        <li class="list-group-item">
                            uploadfile
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">必須</li>
                                <li class="list-group-item">バイナリ型</li>
                                <li class="list-group-item">ファイルバイナリ</li>
                                <li class="list-group-item">ファイルデータです。</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="col-12">
                <label>URLサンプル</label>
                <div class="input-group">
                    http://localhost:8888/api/fileupload.php
                </div>
            </div>

            <div class="col-12">
                <label>返却値サンプル</label>
                <div class="input-group">
                    <code>
                        {
                        "publicgroupid": "1be9dbf4e8b841a29e017649d063e9ab"
                        ,"dataid": 4
                        }

                    </code>
                </div>
            </div>

        </div>

    </div>


</div>


</br>
</br>
</br>
</br>
</br>


</body>
</html>







