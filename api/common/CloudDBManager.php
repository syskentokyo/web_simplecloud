<?php

namespace Syskentokyo\SimpleCloud;


require_once('Commondefine.php');
require_once('FileInfo.php');
require_once('GroupInfo.php');

use Ramsey\Uuid\Uuid;
use PDO;

 class CloudDBManager{
    private static function CreateDB():?PDO {
        $dbpath = __DIR__ . "AppDBManager.php/" . DB_FILE_PATH ;

        $dboptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $appDBPdo = new PDO('sqlite:' . $dbpath, null, null, $dboptions);

            //
            // テーブル作成
            //
            CloudDBManager::InitTable($appDBPdo);


            return $appDBPdo;
        }catch (Exception $e) {
            echo $e;
            return null;
        }
    }

    private static function InitTable($appDBPdo){

        $sql = "CREATE TABLE IF NOT EXISTS filelist (
                 id INTEGER NOT NULL  PRIMARY KEY AUTOINCREMENT,
                 savedirname TEXT NOT NULL,
                 savefilename TEXT NOT NULL,
                 groupid INTEGER NOT NULL,
                 ispinned INTEGER,
                 isactive INTEGER,
                 memo1 TEXT,
                 createtime TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime'))
             )";

        $appDBPdo->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS grouplist (
                 id INTEGER NOT NULL  PRIMARY KEY AUTOINCREMENT,
                 publicid TEXT NOT NULL,
                 groupname TEXT,
                 memo1 TEXT,
                 createtime TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime'))
             )";

        $appDBPdo->query($sql);


    }

     public static function InsertGroupList($groupName,$memo1)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         $publicid =Uuid::uuid4()->toString();
         $publicid=  str_replace("-","",$publicid);


         //SQL準備
         $stmt = $appDBPdo->prepare("INSERT INTO grouplist(	publicid, groupname,memo1) VALUES (:publicid, :groupname,:memo1)");


         $stmt->bindValue( ':publicid',$publicid , SQLITE3_TEXT);
         $stmt->bindValue( ':groupname', $groupName, SQLITE3_TEXT);
         $stmt->bindValue( ':memo1', $memo1, SQLITE3_TEXT);

         $res = $stmt->execute();//実行

         $insertDataID=-999;

         if($res === true){
             $insertDataID = (int) $appDBPdo->lastInsertId();
             $appDBPdo = null;
         }else{
             $appDBPdo = null;
         }

         return $insertDataID;

     }


     public static function InsertFileList($groupID,$saveDirName,$saveFileName,$memo1)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //



         //SQL準備
         $stmt = $appDBPdo->prepare("INSERT INTO filelist(	savedirname, savefilename,groupid,memo1,ispinned,isactive) VALUES (:savedirname, :savefilename,:groupid,:memo1,:ispinned,:isactive)");


         $stmt->bindValue( ':savedirname', $saveDirName, SQLITE3_TEXT);
         $stmt->bindValue( ':savefilename', $saveFileName, SQLITE3_TEXT);
         $stmt->bindValue( ':groupid', $groupID, SQLITE3_INTEGER);
         $stmt->bindValue( ':memo1', $memo1, SQLITE3_TEXT);
         $stmt->bindValue( ':ispinned', 0, SQLITE3_INTEGER);
         $stmt->bindValue( ':isactive', 0, SQLITE3_INTEGER);

         $res = $stmt->execute();//実行

         $insertDataID=-999;

         if($res === true){
             $insertDataID = (int) $appDBPdo->lastInsertId();
             $appDBPdo = null;
         }else{
             $appDBPdo = null;
         }

         return $insertDataID;

     }


     public static function SelectFromGroupList($groupID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM grouplist WHERE id = :groupID");


         $stmt->bindValue( ':groupID', $groupID, SQLITE3_INTEGER);

         $res = $stmt->execute();



         $groupInfo = new GroupInfo();

        if( $res ) {
            $data = $stmt->fetch();


            //データ整理
            $groupInfo->id = $data["id"];
            $groupInfo->publicid = $data["publicid"];
            $groupInfo->groupname = $data["groupname"];
            $groupInfo->memo1 = $data["memo1"];
            $groupInfo->createtime = $data["createtime"];

        }

         $appDBPdo = null;


         return $groupInfo;

     }









     public static function SelectAllGroupInfo()
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM grouplist ORDER BY id DESC");


         $res = $stmt->execute();



         $validatedDataArray = array();

         if( $res ) {
             $dataArray = $stmt->fetchAll();


             foreach ($dataArray as $data) {

                 $groupInfo = new GroupInfo();

                 //データ整理
                 $groupInfo->id = $data["id"];
                 $groupInfo->publicid = $data["publicid"];
                 $groupInfo->groupname = $data["groupname"];
                 $groupInfo->memo1 = $data["memo1"];
                 $groupInfo->createtime = $data["createtime"];



                 //配列へ追加
                 $validatedDataArray[]=$groupInfo;
             }
         }
         $appDBPdo = null;


         return $validatedDataArray;

     }

     public static function SelectGroupInfo($groupID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM grouplist WHERE id = :groupID  ORDER BY id DESC");

         $stmt->bindValue( ':groupID', $groupID, SQLITE3_INTEGER);


         $res = $stmt->execute();



         $groupInfo = new GroupInfo();
         if( $res ) {
             $data = $stmt->fetch();

                 //データ整理
                 $groupInfo->id = $data["id"];
                 $groupInfo->publicid = $data["publicid"];
                 $groupInfo->groupname = $data["groupname"];
                 $groupInfo->memo1 = $data["memo1"];
                 $groupInfo->createtime = $data["createtime"];


         }
         $appDBPdo = null;


         return $groupInfo;

     }

     public static function SelectGroupInfoByPublicID($publicGroupID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM grouplist WHERE publicid = :publicid  ORDER BY id DESC");

         $stmt->bindValue( ':publicid', $publicGroupID, SQLITE3_TEXT);


         $res = $stmt->execute();



         $groupInfo = new GroupInfo();
         if( $res ) {
             $data = $stmt->fetch();

             //データ整理
             $groupInfo->id = $data["id"];
             $groupInfo->publicid = $data["publicid"];
             $groupInfo->groupname = $data["groupname"];
             $groupInfo->memo1 = $data["memo1"];
             $groupInfo->createtime = $data["createtime"];


         }
         $appDBPdo = null;


         return $groupInfo;

     }

     public static function SelectAllFileInfo()
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM filelist ORDER BY id DESC");


         $res = $stmt->execute();



         $validatedDataArray = array();

         if( $res ) {
             $dataArray = $stmt->fetchAll();


             foreach ($dataArray as $data) {

                 $fileInfo = new FileInfo();

                 //データ整理
                 $fileInfo->dataID = $data["id"];
                 $fileInfo->savedirname = $data["savedirname"];
                 $fileInfo->savefilename = $data["savefilename"];
                 $fileInfo->groupID = $data["groupid"];
                 $fileInfo->ispinned = $data["ispinned"];
                 $fileInfo->isactive = $data["isactive"];
                 $fileInfo->memo1 = $data["memo1"];
                 $fileInfo->createtime = $data["createtime"];


                 //配列へ追加
                 $validatedDataArray[]=$fileInfo;
             }
         }
         $appDBPdo = null;


         return $validatedDataArray;

     }
     public static function SelectFileInfoOnGroup($groupID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM filelist WHERE groupid = :groupID ORDER BY id DESC");

         $stmt->bindValue( ':groupID', $groupID, SQLITE3_INTEGER);

         $res = $stmt->execute();



         $validatedDataArray = array();

         if( $res ) {
             $dataArray = $stmt->fetchAll();


             foreach ($dataArray as $data) {

                 $fileInfo = new FileInfo();

                 //データ整理
                 $fileInfo->dataID = $data["id"];
                 $fileInfo->savedirname = $data["savedirname"];
                 $fileInfo->savefilename = $data["savefilename"];
                 $fileInfo->groupID = $data["groupid"];
                 $fileInfo->ispinned = $data["ispinned"];
                 $fileInfo->isactive = $data["isactive"];
                 $fileInfo->memo1 = $data["memo1"];
                 $fileInfo->createtime = $data["createtime"];


                 //配列へ追加
                 $validatedDataArray[]=$fileInfo;
             }
         }
         $appDBPdo = null;


         return $validatedDataArray;

     }

     public static function SelectFileInfoPinnedOnGroup($groupID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM filelist WHERE groupid = :groupID AND ispinned = 1 AND isactive = 1 ORDER BY id DESC");

         $stmt->bindValue( ':groupID', $groupID, SQLITE3_INTEGER);

         $res = $stmt->execute();



         $validatedDataArray = array();

         if( $res ) {
             $dataArray = $stmt->fetchAll();


             foreach ($dataArray as $data) {

                 $fileInfo = new FileInfo();

                 //データ整理
                 $fileInfo->dataID = $data["id"];
                 $fileInfo->savedirname = $data["savedirname"];
                 $fileInfo->savefilename = $data["savefilename"];
                 $fileInfo->groupID = $data["groupid"];
                 $fileInfo->ispinned = $data["ispinned"];
                 $fileInfo->isactive = $data["isactive"];
                 $fileInfo->memo1 = $data["memo1"];
                 $fileInfo->createtime = $data["createtime"];


                 //配列へ追加
                 $validatedDataArray[]=$fileInfo;
             }
         }
         $appDBPdo = null;


         return $validatedDataArray;

     }

     public static function SelectFileInfoActiveOnlyOnGroup($groupID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM filelist WHERE groupid = :groupID AND isactive = 1 ORDER BY id DESC");

         $stmt->bindValue( ':groupID', $groupID, SQLITE3_INTEGER);

         $res = $stmt->execute();



         $validatedDataArray = array();

         if( $res ) {
             $dataArray = $stmt->fetchAll();


             foreach ($dataArray as $data) {

                 $fileInfo = new FileInfo();

                 //データ整理
                 $fileInfo->dataID = $data["id"];
                 $fileInfo->savedirname = $data["savedirname"];
                 $fileInfo->savefilename = $data["savefilename"];
                 $fileInfo->groupID = $data["groupid"];
                 $fileInfo->ispinned = $data["ispinned"];
                 $fileInfo->isactive = $data["isactive"];
                 $fileInfo->memo1 = $data["memo1"];
                 $fileInfo->createtime = $data["createtime"];


                 //配列へ追加
                 $validatedDataArray[]=$fileInfo;
             }
         }
         $appDBPdo = null;


         return $validatedDataArray;

     }

     public static function SelectOneFileInfoActiveOnlyOnGroup($groupID,$dataID)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("SELECT * FROM filelist WHERE groupid = :groupID AND id = :dataid  AND isactive = 1 ORDER BY id DESC");

         $stmt->bindValue( ':groupID', $groupID, SQLITE3_INTEGER);
         $stmt->bindValue( ':dataid', $dataID, SQLITE3_INTEGER);

         $res = $stmt->execute();



         $validatedDataArray = array();

         if( $res ) {
             $dataArray = $stmt->fetchAll();


             foreach ($dataArray as $data) {

                 $fileInfo = new FileInfo();

                 //データ整理
                 $fileInfo->dataID = $data["id"];
                 $fileInfo->savedirname = $data["savedirname"];
                 $fileInfo->savefilename = $data["savefilename"];
                 $fileInfo->groupID = $data["groupid"];
                 $fileInfo->ispinned = $data["ispinned"];
                 $fileInfo->isactive = $data["isactive"];
                 $fileInfo->memo1 = $data["memo1"];
                 $fileInfo->createtime = $data["createtime"];


                 //配列へ追加
                 $validatedDataArray[]=$fileInfo;
             }
         }
         $appDBPdo = null;


         return $validatedDataArray;

     }




     public static function UpdatePinActive($dataID,$validatedGroupID,$setActive)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //
        //同じグループのをすべてオフにする
         $stmt = $appDBPdo->prepare("UPDATE filelist SET ispinned = 0 WHERE groupid = :groupid");
         $stmt->bindValue( ':groupid', $validatedGroupID, SQLITE3_INTEGER);
         $res = $stmt->execute();



         //SQL準備
         $stmt = $appDBPdo->prepare("UPDATE  filelist SET ispinned = :ispinned WHERE id = :dataID");

         $stmt->bindValue( ':ispinned', $setActive, SQLITE3_INTEGER);
         $stmt->bindValue( ':dataID', $dataID, SQLITE3_INTEGER);

         $res = $stmt->execute();


         $appDBPdo = null;


         return;

     }

     public static function UpdateFileActive($dataID,$setActive)
     {
         $appDBPdo = self::CreateDB();
         if($appDBPdo ==null){
             return;
         }

         //
         //
         //

         //SQL準備
         $stmt = $appDBPdo->prepare("UPDATE  filelist SET isactive = :isactive WHERE id = :dataID");

         $stmt->bindValue( ':isactive', $setActive, SQLITE3_INTEGER);
         $stmt->bindValue( ':dataID', $dataID, SQLITE3_INTEGER);

         $res = $stmt->execute();


         $appDBPdo = null;


         return;

     }



 }





