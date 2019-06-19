<?php
/* @var $this yii\web\View */
?>

<div class="row" style = "margin-top: 10px">

    <table class="table">
        <thead>
            <tr>
                <th scope="col"> <h3> Дата добавления</h3></th>
                <th scope="col"> <h3>Название</h3></th>
                <th scope="col"> <h3>Срок</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tests as $t):?>
                <tr>
                    <?php
                    echo "<td> <h5>" .htmlspecialchars($t['dateOfStart'])."</h5></td>";
                    echo "<td><h5><a href='?r=student/tests&id=".$t['id']."'>".$t['name']."</a></h5></td>";  
                    echo "<td><h5> ".$t['dateOfEnd']."</h5></td>";
                    ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    

</div>