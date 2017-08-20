<?php
include_once "settings.php";
include_once "functions.php";
include_once "./parts/nav.php";
$title = '合作者模型';
if (isset($_POST['platform_n']))
    $platform_n= $_POST['platform_n'];
if (isset($_POST['n']))
    $n= $_POST['n'];
if (isset($_POST['service_charge']))
    $service_charge= $_POST['service_charge'];
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
$work_net_income = work_net_income($service_charge, $dis_m, $platform_n);
$work_total_income = work_total_income($service_charge, $platform_n);
$direct_bonus = $cost * $dis_c;
$bonus_down = $users[0]->getBdown();
$diff = $direct_bonus + $bonus_down + $work_net_income - $work_total_income;
?>
<html>
<head>
    <?php include_once "./parts/page_head.php"?>
</head>
<body>
<style>
    .negative {
        background-color: red;
    }
    .positive {
        background-color: green;
    }
</style>
<?php get_nav($navs);?>
<div class="container main-content">
    <div class="page-title" style="text-align: center">
        <h2>合作者设定</h2></div>
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="<?php $_SERVER["PHP_SELF"]?>">
                <div class="form-group row">
                    <label class="col-form-label" for="service_charge">单用户服务消费</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="service_charge" name="service_charge" placeholder="单用户服务消费" value="<?php echo $service_charge ?>">
                    </div>
                    <label class="col-form-label" for="platform_n">平台派单数</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="platform_n" name="platform_n" placeholder="平台派单数" value="<?php echo $platform_n ?>">
                    </div>
                    <label class="col-form-label" for="cost">平均年消费</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="cost" name="cost" placeholder="输入年消费" value="<?php echo $cost ?>">
                    </div>
                    <label class="col-form-label" for="dis_m">商家端折扣率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" class="form-control" id="dis_m" name="dis_m" placeholder="输入商家折扣率" value="<?php echo $dis_m ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label" for="dis_c">直接返点率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" class="form-control" id="dis_c" name="dis_c" placeholder="输入直接返点率" value="<?php echo $dis_c ?>">
                    </div>
                    <label class="col-form-label" for="dis_c">推荐返点率</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.001" class="form-control" id="level_up" name="level_up" placeholder="输入推荐返点率" value="<?php echo $level_up ?>">
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
            <h2 style="text-align: center">合作者数据</h2>
            <table class="table table-bordered table-striped table-hover" id="dataTable1">
                <thead>
                <th>下线总数</th>
                <th>服务总收入</th>
                <th>平台费用支出</th>
                <th>净收入</th>
                <th>直接返点</th>
                <th>推荐返点</th>
                <th>总返点</th>
                <th>盈利情况</th>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $count-1 ?></td>
                    <td><?php echo $work_total_income ?></td>
                    <td><?php echo $work_total_income - $work_net_income ?></td>
                    <td><?php echo $work_net_income ?></td>
                    <td><?php echo $direct_bonus ?></td>
                    <td><?php echo $bonus_down ?></td>
                    <td><?php echo $direct_bonus+$bonus_down ?></td>
                    <td <?php if ($diff<0) {
                        echo 'class="negative"';
                    }
                    else
                        echo 'class="positive"';
                        ?>><?php echo $diff ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
