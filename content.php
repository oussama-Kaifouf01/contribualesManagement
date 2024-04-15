<h1 class="mt-4">
    <?php echo $_GET["page"] ?>
</h1>
<div class="row">
    <?php
    if ($_GET["page"]=="Contribuables" && isset($_GET["action"])==false ) {
        include 'CRUD\contribuables\list.php';
    }
    if ($_GET["page"]=="Contribuables" && $_GET["action"]=="add" ) {
        include 'CRUD\contribuables\add.php';
    }

    if ($_GET["page"]=="Demandes" && $_GET["action"]=="add" ) {
        include 'CRUD\demandes\add.php';
    }

    ?>

</div>