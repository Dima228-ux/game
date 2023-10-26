<?php
/**
 * @var $game \app\models\SessionGame
 */

use yii\bootstrap4\Html;

$end = 'false';
$session = Yii::$app->session;
$move = 'go';

if ($game['move_player1'] && $game['id_user1'] == Yii::$app->user->id) {
    $move = 'stop';
} elseif ($game['move_player2'] && $game['id_user2'] == Yii::$app->user->id) {
    $move = 'stop';
} elseif ($game['id_user1'] == null || $game['id_user2'] == null) {
    $move = 'stop';
}

if ($session->isActive) {

    if ($session['game'] === false) {
        $end = 'true';

    } elseif ($session['game'] === 'stop') {
        $end = 'true';
    }
}

?>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <?= Html::a(
                'Exit',
                [
                    '/session/break-game',
                    'id' => $game['id_room'],

                ],

                [
                    'class' => 'btn btn-mini btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to exit this game?', 'method' => 'post',
                    ],
                ])
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10">
        <div class="box box-body box-success">
            <div class="box-header">
                <h3 class="box-title">Game</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover">
                        <?
                        for ($i = 1; $i <= 9; $i++) {
                            if ($i == 1) {
                                echo '<tr>' . "\n";;
                            }
                            echo '<td><button id="id_' . $i . '" onclick="foo_' . $i . '()" class="block" >' . $game['collum' . $i] . '</button></td>' . "\n";
                            if (($i % 3 == 0)) {
                                echo '</tr><tr>' . "\n";;
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<? echo '<script >
var permennaya , button, allBlock;';
for ($i = 1; $i < 10; $i++) {
    $foo = 'foo_' . $i;
    $id = 'id_' . $i;
    echo ' function  ' . $foo . ' (){         
         let move="' . $move . '";
         let local_go="go";
         button =document.getElementById("' . $id . '").innerHTML; //alertbutton;
        if(button === "" && move!="stop" && local_go!="stop" ) {
        local_go="stop";
          ajax("' . $i . '")
        }  
     
    }';
}
?>
let end='<?php echo $end ?>';
if(end=='true'){
setInterval(room, 1000);
}

function room() {

let id_room=<?php echo $game['id_room'] ?>;

$.ajax({
type: "post",
url: "/web/session/exit",
data: {
'id_room':id_room
},
success: function(data) {
console.log(data);
end='false';
}
});
}

function ajax(collumn) {

let id_room=<?php echo $game['id_room'] ?>;
$.ajax({
type: "post",
url: "/web/session/move-player",
data: {
'id_collum':collumn,
'id_room':id_room
},
success: function(data) {
console.log(data);


}
});
}


setInterval(upload, 1000);


function upload() {

let id_room=<?php echo $game['id_room'] ?>;
$.ajax({
type: "post",
url: "/web/session/upload-move",
data: {
'id_room':id_room
},
success: function(data) {
console.log(data);

}
});
}


</script>

<style>
    button {

        width: 50px;

        height: 50px;

    }

    table.center {

        top: 50%;

        left: 50%;

        width: 160px;

        height: 160px;

        position: absolute;

        margin-left: -80px;

        margin-top: -80px;

    }

</style>