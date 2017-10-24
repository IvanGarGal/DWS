<HTML>
    <HEAD>
        <meta charset="UTF-8">
        <title></title>
    </HEAD>
    <BODY>
        
        <?php
            foreach ($_REQUEST as $key => $val) {
                echo "<h1>";
                echo $key . " ==> " ."<span style='color:".$key."'>".$val."</span>";
                echo "</h1>";
            }
        ?>
        
    </BODY>
</HTML>
