<?php

    if (nkHasAdmin())
    {
        if (isset($_POST) && isset($_POST['tableDnD']) && $_POST['tableDnD'] == '1')
        {
            $old = $_POST['old'];
            $new = $_POST['new'];
            $table = $_POST['table'];

            $sql = "UPDATE ".$table." SET `order` = '-1' WHERE `order` = '".$old."' ";
            mysql_query($sql) or die(nk_debug_bt());

            if ($old < $new)
            {
                $sql = "UPDATE ".$table." SET `order` = `order` - 1 WHERE `order` > '".$old."' AND `order` <= '".$new."' ";
                mysql_query($sql) or die(nk_debug_bt());
            }
            else if ($old > $new)
            {
                $sql = "UPDATE ".$table." SET `order` = `order` + 1 WHERE `order` < '".$old."' AND `order` >= '".$new."' ";
                mysql_query($sql) or die(nk_debug_bt());
            }

            $sql = "UPDATE ".$table." SET `order` = '".$new."' WHERE `order` = '-1' ";
            mysql_query($sql) or die(nk_debug_bt());

            echo json_encode('ok');
            die;
        }
    }

?>
