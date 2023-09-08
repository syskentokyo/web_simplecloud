<?php

namespace Syskentokyo\SimpleCloud;


enum AppFilePlatform:int
{
    case iOS=1;
    case Android=2;
}

define ("CURRENT_URL",(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
define ("CURRENT_BASE_URL",(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] );

const MANAGER_DIR_NAME = "manager";

const USER_DIR_NAME = "api";

const SAVEDATA_DIR_NAME = "savedata";



const UPLOAD_FILE_DIR = MANAGER_DIR_NAME."/uploadfile.php";

const CREATE_GROUP_DIR = MANAGER_DIR_NAME."/creategroup.php";

const GROUP_LIST_DIR = MANAGER_DIR_NAME."/grouplist.php";

const MANAGE_DISTRIBUTION_DIR = MANAGER_DIR_NAME."/index.php";

const CREATE_DISTRIBUTION_DIR = MANAGER_DIR_NAME."/createdistribution.php";

const FILE_SAVEDIR = USER_DIR_NAME."/".SAVEDATA_DIR_NAME."/publicfile/";
const FILE_SAVEDIR_PATH = "../".FILE_SAVEDIR;
const DB_FILE_PATH = "../".SAVEDATA_DIR_NAME."/masterdb/master.sqlite3";

