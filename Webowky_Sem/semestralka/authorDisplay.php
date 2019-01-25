<?php
include 'elementals/header.php';
?><link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <main>

        <div class="center-wrapper">
            <div>
                <?php if (empty($_GET['idAutoria']) == false){ ?>
                <h1 align="center"><?php
                    echo $_GET['nickname']?></h1>
                <h2>List of sites</h2>
                <h2>List of fics</h2>
                <h2>Assorted tags</h2>
                <h2>Reviews</h2>
                <?php } else{?>
                    <h1 align="center">You are not supposed to be here</h1>

                <?php }?>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>