<?php
include_once "functions.php";
include_once "./parts/nav.php";
$title ="浮动模式";

if (isset($_POST['n']))
    $n= $_POST['n'];
if (isset($_POST['levels']))
    $levels= $_POST['levels'];
if (isset($_POST['cost']))
    $cost= $_POST['cost'];

if (isset($_POST['level_up']))
    $level_up= $_POST['level_up'];
if (isset($_POST['up']))
    $up= $_POST['up'];
if (isset($_POST['fee']))
    $fee= $_POST['fee'];
if (isset($_POST['dis_m']))
    $dis_m= $_POST['dis_m'];
if (isset($_POST['flex_rate']))
    $flex_rate= $_POST['flex_rate'];
if (isset($_POST['step']))
    $step= $_POST['step'];
$dis_c = $dis_m / 2.0;

$users = init($n, $levels);
$rates = flexLevelUp($dis_c, $flex_rate, $step, $up);
flexRun($users, $cost, $dis_c, $rates, $up);

$count=count($users);
$direct_bonus = $cost * $dis_c;
$bonus_down = $users[0]->getBdown();
?>
<html>
<head>
    <?php include_once "./parts/page_head.php"?>
</head>
<body>

<?php

get_nav($navs);
?>
<div class="container main-content">
    <div class="page-title" style="text-align: center">
        <h2>浮动机制设定</h2></div>
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="<?php $_SERVER["PHP_SELF"]?>">
                <div class="form-group row">

                    <label class="col-form-label" for="cost">平均年消费</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="cost" name="cost" placeholder="输入年消费" value="<?php echo $cost ?>">
                    </div>
                    <label class="col-form-label" for="dis_m">商家端折扣率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" class="form-control" id="dis_m" name="dis_m" placeholder="输入商家折扣率" value="<?php echo $dis_m ?>">
                    </div>
                    <label class="col-form-label" for="dis_c">直接返点率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" class="form-control" id="dis_c" name="dis_c" placeholder="输入直接返点率" value="<?php echo $dis_c ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-form-label" for="flex_rate" data-toggle="tooltip" data-placement="left" title="直接上线返点比例与直接返点率的比值，再向上逐层递减">最大推荐返点比例</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" class="form-control" id="flex_rate" name="flex_rate" placeholder="输入推荐返点率" value="<?php echo $flex_rate ?>">
                    </div><label class="col-form-label" for="step">步进</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.1" class="form-control" id="step" name="step" placeholder="步进" value="<?php echo $step ?>">
                    </div>
                    <label class="col-form-label" for="n">单用户推荐人数</label>
                    <div class="col-sm-1">
                        <input type="number" step="1" class="form-control" id="n" name="n" placeholder="推荐人数" value="<?php echo $n ?>">
                    </div>
                    <label class="col-form-label" for="levels">系统代数</label>
                    <div class="col-sm-1">
                        <input type="number" step="1" class="form-control" id="levels" name="levels" placeholder="系统代数" value="<?php echo $levels ?>">
                    </div>
                    <label class="col-form-label" for="up">返利代数</label>
                    <div class="col-sm-1">
                        <input type="number" step="1" class="form-control" id="up" name="up" placeholder="系统代数" value="<?php echo $up ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">计算</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2 style="text-align: center">浮动数据</h2>
            <table class="table table-bordered table-striped table-hover" id="dataTable1">
                <thead>
                <th>下线总数</th>
                <th>直接返点</th>
                <th>推荐返点</th>
                <th>总返点</th>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $count-1 ?></td>
                    <td><?php echo $direct_bonus ?></td>
                    <td><?php echo $bonus_down ?></td>
                    <td><?php echo $direct_bonus+$bonus_down ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>