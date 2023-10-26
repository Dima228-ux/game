<?php
/**
 * @var $statistic \app\models\Statistics
 */

use yii\bootstrap4\Html;
use app\models\Statistics;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-xs-12 col-md-10">
        <div class="box box-body box-success">
            <div class="box-header">
                <h3 class="box-title">Statistic</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Count Game</th>
                            <th>Count Wins</th>
                            <th>Count Defeats</th>
                            <th>Count Draws</th>
                            <th>Percent Wins </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($statistic)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No statistic was found</td>
                            </tr>
                        <?php else: ?>

                            <tr data-id="<?= $statistic['id'] ?>">
                                <td><?= $statistic['count_game'] ?></td>
                                <td><?= $statistic['count_wins'] ?></td>
                                <td><?= $statistic['count_defeats']  ?></td>
                                <td><?= $statistic['count_draws']  ?></td>
                                <td><?= $statistic['count_wins']*100/ $statistic['count_game'] ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
