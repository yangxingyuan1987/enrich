<!doctype html>
<?php
include_once "functions.php";
include_once "./parts/nav.php";
include_once "settings.php";
$title = "不同模式对比";
if (isset($_POST['n']))
    $n= $_POST['n'];
if (isset($_POST['levels']))
    $levels= $_POST['levels'];
if (isset($_POST['cost']))
    $cost= $_POST['cost'];
if (isset($_POST['dis_c']))
    $dis_c= $_POST['dis_c'];
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
if (isset($_POST['step1']))
    $step= $_POST['step1'];
if (isset($_POST['step2']))
    $step2= $_POST['step2'];
else $step2 =0.6;
if (isset($_POST['level_up']))
    $level_up= $_POST['level_up'];

$users = init($n, $levels);
$count=count($users);

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
        <h2>黑卡系统设定</h2></div>
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
                        <input type="number" step="0.01" class="form-control" id="dis_c" name="dis_c" placeholder="输入直接返点率" value="<?php echo $dis_c ?>" >
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label" for="dis_c">固定推荐返点率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.001" class="form-control" id="level_up" name="level_up" placeholder="输入固定推荐返点率" value="<?php echo $level_up ?>">
                    </div>
                    <label class="col-form-label" for="flex_rate" data-toggle="tooltip" data-placement="left" title="直接上线返点比例与直接返点率的比值，再向上逐层递减">最大推荐返点比例</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" class="form-control" id="flex_rate" name="flex_rate" placeholder="输入推荐返点率" value="<?php echo $flex_rate ?>">
                    </div>
                    <label class="col-form-label" for="step1">步进1</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.1" class="form-control" id="step1" name="step1" placeholder="输入步进1" value="<?php echo $step ?>" >
                    </div>
                    <label class="col-form-label" for="step2">步进2</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.1" class="form-control" id="step2" name="step2" placeholder="输入步进2" value="<?php echo $step2 ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label" for="n">单用户推荐人数</label>
                    <div class="col-sm-2">
                        <input type="number" step="1" class="form-control" id="n" name="n" placeholder="推荐人数" value="<?php echo $n ?>">
                    </div>
                    <label class="col-form-label" for="levels">系统代数</label>
                    <div class="col-sm-2">
                        <input type="number" step="1" class="form-control" id="levels" name="levels" placeholder="系统代数" value="<?php echo $levels ?>">
                    </div>
                    <label class="col-form-label" for="up">返利代数</label>
                    <div class="col-sm-2">
                        <input type="number" step="1" class="form-control" id="up" name="up" placeholder="系统代数" value="<?php echo $up ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">计算</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2 style="text-align: center">平台数据</h2>
            <table class="table table-bordered table-striped table-hover" id="dataTable1">
                <thead>
                <th>模式</th>
                <th>步进</th>
                <th>用户总数</th>
                <th>总收入</th>
                <th>服务支出</th>
                <th>直接返点支出</th>
                <th>推荐返点支出</th>
                <th>总支出</th>
                <th>利润</th>
                <th>利润率</th>
                </thead>
                <tbody>
                <tr>
                    <?php
                    run($users, $cost, $dis_c, $level_up, $up);
                    $totalF =  totalFee($users, $fee);
                    $totalSI = totalServiceIncome($users);
                    $totalI =  totalIncome($users, $fee);
                    $totalBD = totalBd($users);
                    $totalBDown =  totalBdown($users);
                    $totalSP = (1-$dis_m)*$totalSI;
                    $profit = $totalI - $totalBD - $totalBDown - $totalSP;
                    $pp = $profit * 1.0 / $totalI * 100.0;
                    ?>
                    <td>固定推荐返点</td>
                    <td></td>
                    <td><?php echo $count ?></td>
                    <td><?php echo number_format($totalI, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalSP, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBD, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBDown, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBD + $totalBDown, 2, '.', '') ?></td>
                    <td><?php echo number_format($profit, 2, '.', '') ?></td>
                    <td><?php echo number_format($pp, 2, '.', '')."%" ?></td>
                </tr>
                <tr>
                    <?php
                    users_reset($users);
                    $rates = flexLevelUp($dis_c, $flex_rate, $step, $up);
                    flexRun($users, $cost, $dis_c, $rates, $up);
                    $totalF =  totalFee($users, $fee);
                    $totalSI = totalServiceIncome($users);
                    $totalI =  totalIncome($users, $fee);
                    $totalBD = totalBd($users);
                    $totalBDown =  totalBdown($users);
                    $totalSP = (1-$dis_m)*$totalSI;
                    $profit = $totalI - $totalBD - $totalBDown - $totalSP;
                    $pp = $profit * 1.0 / $totalI * 100.0;
                    ?>
                    <td>浮动推荐返点</td>
                    <td><?php echo $step?></td>
                    <td><?php echo $count ?></td>
                    <td><?php echo number_format($totalI, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalSP, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBD, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBDown, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBD + $totalBDown, 2, '.', '') ?></td>
                    <td><?php echo number_format($profit, 2, '.', '') ?></td>
                    <td><?php echo number_format($pp, 2, '.', '')."%" ?></td>
                </tr>
                <tr>
                    <?php
                    users_reset($users);
                    $rates = flexLevelUp($dis_c, $flex_rate, $step2, $up);
                    flexRun($users, $cost, $dis_c, $rates, $up);
                    $totalF =  totalFee($users, $fee);
                    $totalSI = totalServiceIncome($users);
                    $totalI =  totalIncome($users, $fee);
                    $totalBD = totalBd($users);
                    $totalBDown =  totalBdown($users);
                    $totalSP = (1-$dis_m)*$totalSI;
                    $profit = $totalI - $totalBD - $totalBDown - $totalSP;
                    $pp = $profit * 1.0 / $totalI * 100.0;
                    ?>
                    <td>浮动推荐返点</td>
                    <td><?= $step2?></td>
                    <td><?php echo $count ?></td>
                    <td><?php echo number_format($totalI, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalSP, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBD, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBDown, 2, '.', '') ?></td>
                    <td><?php echo number_format($totalBD + $totalBDown, 2, '.', '') ?></td>
                    <td><?php echo number_format($profit, 2, '.', '') ?></td>
                    <td><?php echo number_format($pp, 2, '.', '')."%" ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
