<?php
namespace Syskentokyo\SimpleCloud;
require_once('../api/common/commonrequireall.php');
?>


<nav class="navbar  navbar-light navbar-expand-lg " style="background-color: #e3f2fd;">
    <div class="container-fluid" style="width: 610px;">
        <a class="navbar-brand" href="<?php echo "../".MANAGE_DISTRIBUTION_DIR."";  ?>" >Top</a>


        <ul class="navbar-nav"  style="width: 30%;">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo "../".DOCS_DIR."";  ?>" >Document</a>
            </li>
        </ul>


        <ul class="navbar-nav"  style="width: 40%;">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo "../".GROUP_LIST_DIR."";  ?>" >Group List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo "../".CREATE_GROUP_DIR."";  ?>" >Create Group</a>
            </li>
        </ul>
    </div>
</nav>

<?php ?>
