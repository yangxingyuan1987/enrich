<?php
include_once "class-user.php";
include_once "settings.php";
/**
*自动生成用户id
*/
function userid($n)
{
    return 'u'.$n;
}
function max_u($n, $levels)
{
    $m=0;
    for($i=0; $i<$levels; $i++)
    {
        $m+=pow($n,$i);
    }
    return $m;
}
/**
 * 建立关系体系，每个人推荐n个，一共level代
*/
function init($n, $levels)
{
    $total = max_u($n, $levels);
    $id=1;
    $top = new user(userid($id), "u0");
    $parentId= $id;
    $id++;
    $users= array($top);
    while ($id<=$total)
    {
        for ($j=0; $j<$n; $j++)
        {
            $users =array_merge($users, array(new user(userid($id), userid($parentId))));
            $id++;
        }
        $parentId += 1;
    }
    return $users;
}
function getParentId($users, $id)
{
    $index = substr($id, 1);
    $i = intval($index)-1;
    return $users[$i]->getParentId();
}
function getUserById($users, $id)
{
    $i = intval(substr($id, 1))-1;
    return $users[$i];
}
function run($users, $amount, $dis_c, $level_up, $up)
{
    for ($j=0; $j<count($users);$j++)
    {
        $users[$j]->addCost($amount);
        $users[$j]->addBd($amount* $dis_c);
        $user = $users[$j];
        for ($i=0; $i<$up && $user->getParentId() != "u0"; $i++)
        {
            $parent = getUserById($users, getParentId($users, $user->getId()));
            $parent->addBdown($user->getCost()*$level_up);
            $user = getUserById($users, $parent->getId());
        }
    }
}

function flexLevelUp($dis_c, $flex_rate, $step, $up)
{
    $rates=array();
    $temp = $dis_c * $flex_rate;
    for ($i=0; $i<$up; $i++)
    {
        $rates = array_merge($rates, array($temp));
        $temp = $temp * $step;
    }
    return $rates;
}
function flexRun($users, $amount, $dis_c, $rates, $up)
{
    for ($j=0; $j<count($users);$j++)
    {
        $users[$j]->addCost($amount);
        $users[$j]->addBd($amount* $dis_c);
        $user = $users[$j];
        for ($i=0; $i<$up && $user->getParentId() != "u0"; $i++)
        {
            $parent = getUserById($users, getParentId($users, $user->getId()));
            $parent->addBdown($user->getCost()*$rates[$i]);
            $user = getUserById($users, $parent->getId());
        }
    }
}
function users_reset($users)
{
    foreach ($users as $user)
    {
        $user->ureset();
    }
}
function totalFee($users, $fee)
{
    return $fee*count($users);
}
function totalServiceIncome($users)
{
    $income =0.0;
    foreach ($users as $user)
    {
        $income += $user->getCost();
    }
    return $income;
}
function totalIncome($users, $fee)
{
    return totalFee($users, $fee) + totalServiceIncome($users);
}
function totalBd($users)
{
    $sum = 0.0;
    foreach ($users as $user)
    {
        $sum += $user->getBd();
    }
    return $sum;
}
function totalBdown($users)
{
    $sum = 0.0;
    foreach ($users as $user)
    {
        $sum += $user->getBdown();
    }
    return $sum;
}

/**
 * 山头的干活收入
 */
function work_net_income($service_charge, $dis_m, $platform_n)
{
    return $platform_n*$service_charge*(1-$dis_m);
}
function work_total_income($service_charge, $platform_n)
{
    return $platform_n*$service_charge;
}
function toJSON($users)
{
	$temp = array();
	foreach($users as $user)
	{
		$temp = array_merge($temp, array($user->toArray()));
	}
	return JSON_encode($temp);
}
?>