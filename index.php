<?php
include_once "settings.php";
include_once "functions.php";
include_once "./parts/nav.php";
$title = '系统模型';
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

$users = init($n, $levels);
run($users, $cost, $dis_c, $level_up, $up);
$count=count($users);
$totalF =  totalFee($users, $fee);
$totalSI = totalServiceIncome($users);
$totalI =  totalIncome($users, $fee);
$totalBD = totalBd($users);
$totalBDown =  totalBdown($users);
$totalSP = (1-$dis_m)*$totalSI;
$profit = $totalI - $totalBD - $totalBDown - $totalSP;
$pp = $profit * 1.0 / $totalI * 100.0;
?>
<html>
<head>
    <?php include_once "./parts/page_head.php"?>
</head>
<body>
<?php get_nav($navs);?>
<div class="container main-content">
    <div class="page-title" style="text-align: center">
        <h2>黑卡系统设定</h2></div>
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="<?php $_SERVER["PHP_SELF"]?>">
                <div class="form-group row">
                    <label class="col-form-label" for="fee">年费</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="fee" name="fee" placeholder="输入年费" value="<?php echo $fee?>">
                    </div>
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
                        <input type="number" step="0.01" class="form-control" id="dis_c" name="dis_c" placeholder="输入直接返点率" value="<?php echo $dis_c ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label" for="dis_c">推荐返点率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.001" class="form-control" id="level_up" name="level_up" placeholder="输入推荐返点率" value="<?php echo $level_up ?>">
                    </div>
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
                <th>用户总数</th>
                <th>年费收入</th>
                <th>服务收入</th>
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
                    <td><?php echo $count ?></td>
                    <td><?php echo $totalF ?></td>
                    <td><?php echo $totalSI ?></td>
                    <td><?php echo $totalI ?></td>
                    <td><?php echo $totalSP ?></td>
                    <td><?php echo $totalBD ?></td>
                    <td><?php echo $totalBDown ?></td>
                    <td><?php echo $totalBD + $totalBDown ?></td>
                    <td><?php echo $profit ?></td>
                    <td><?php echo number_format($pp, 2, '.', '')."%" ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2 style="text-align: center">用户明细</h2>
            <table class="table table-bordered table-striped table-hover" id="dataTable2">
                <thead>
                <th>ID</th>
                <th>上级ID</th>
                <th>消费</th>
                <th>直接返利</th>
                <th>推荐返利</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user)
                    {
                        echo "<tr>";
                        echo "<td>" .$user->getId()."</td>";
                        echo "<td>" .$user->getParentId()."</td>";
                        echo "<td>" .$user->getCost()."</td>";
                        echo "<td>" .$user->getBd()."</td>";
                        echo "<td>" .$user->getBdown()."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
