<?php
/**
 * @var $rooms \app\models\Room[]
 * @var $model \app\models\RoomsForm
 * @var $count_free
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\models\Room;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

if (empty($rooms)) {
    $count= 0;
}else{
    $count=count($rooms);
}

?>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <?php
            Modal::begin([
                'toggleButton' => [
                    'label' => 'Add room',
                    'tag' => 'button',
                    'class' => 'btn btn-primary',

                ],

            ]);
            ?> <?php $form = ActiveForm::begin(['id' => 'room-form', 'action' => ['/rooms/add-room']]); ?>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Add room',
                    ['class' => 'btn btn-primary',
                        'name' => 'param-button',]
                ) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <?php Modal::end(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-10">
        <div class="box box-body box-success">
            <div class="box-header">
                <h3 class="box-title">Rooms list</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name Room</th>
                            <th>Count Users</th>
                            <th>Status</th>
                            <th class="text-left"><i class="fa fa-gear fa-lg"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($rooms)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No rooms was found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($rooms as $room): ?>
                                <tr data-id="<?= $room['id'] ?>">
                                    <td><?= Html::decode($room['name']); ?></td>
                                    <td><?= $room['count_users'] ?></td>
                                    <td><?= Room::getStatuses($room['is_free']) ?></td>
                                    <?php if ($room['is_free']): ?>
                                        <td class="text-left"> <?= Html::a('Entrance', ['session/entrance', 'id' => $room['id']], ['class' => 'btn btn-mini btn-primary', 'disabled' => $room['count_users'] == 2,]) ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    setInterval(ajax, 2000);

    function ajax() {

        let id =<?php
            if (empty($rooms)) {
                echo 0;
            }
            echo array_pop($rooms)['id']
            ?>;
        let count =<?php
            echo  $count
             ?>;
        let count_free =<?php
            echo $count_free
            ?>;
        $.ajax({
            type: "post",
            url: "/web/rooms/upload-room",
            data: {
                'id': id,
                'count': count,
                'count_free': count_free,
            },
            success: function (data) {
                console.log(data);

            }
        });
    }
</script>