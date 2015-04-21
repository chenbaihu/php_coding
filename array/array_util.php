<?php
// 排序
//bool sort(array &$array [, int $sort_flags ]);     //对数组进行排序
//bool rsort(array &$array [, int $sort_flags ]);    //对数组进行逆向排序
//可选的第二个参数 sort_flags 可以用以下值改变排序的行为：
//排序类型标记：
//SORT_REGULAR - 正常比较单元（不改变类型）
//SORT_NUMERIC - 单元被作为数字来比较
//SORT_STRING - 单元被作为字符串来比较
//SORT_LOCALE_STRING - 根据当前的区域（locale）设置来把单元当作字符串比较。PHP 4.4.0 和 5.0.2 新加。在 PHP 6 之前，使用了系统的区域设置，可以用 setlocale() 来改变。自 PHP 6 起，必须用 i18n_loc_set_default() 函数。

//此函数为 array 中的元素赋与新的键名。这将删除原有的键名，而不是仅仅将键名重新排序。成功时返回 TRUE， 或者在失败时返回 FALSE.
//例如：
$fruits = array("lemon", "orange", "banana", "apple");
sort($fruits);
foreach ($fruits as $key => $val) {
    echo "fruits[".$key."] = " . $val . "\n";
}

//bool ksort(array &$array [, int $sort_flags ]);    //对数组按照键名排序
//bool krsort(array &$array [, int $sort_flags ]);   //对数组按照键名逆向排序
//例如:
$fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
ksort($fruits);
foreach ($fruits as $key => $val) {
   echo "$key = $val\n";
}

//bool asort ( array &$array [, int $sort_flags ] );     // 对数组进行排序并保持索引关系
//bool arsort ( array &$array [, int $sort_flags ] );    // 对数组进行逆向排序并保持索引关系
//例如：
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
arsort($fruits);
foreach ($fruits as $key => $val) {
    echo "$key = $val\n";
}

//使用自定义函数对数据进行排序：
//bool usort ( array &$array , callable $cmp_function )
//bool uasort ( array &$array , callable $cmp_function )
//bool uksort ( array &$array , callable $cmp_function )
//例如：
function my_sort($l, $r)
{
    if ($l["midsnum"] == $r["midsnum"]) {
        return 0;
    } else if ($l["midsnum"] < $r["midsnum"]) {
        return 1;
    }
    return -1;
}

uasort($info, "my_sort");

// array key 和 value 单独操作
//array array_keys ( array $input [, mixed $search_value = NULL [, bool $strict = false ]] )  //返回数组中所有的键名
//例如：
$array = array(0 => 100, "color" => "red");
print_r(array_keys($array));

$array = array("blue", "red", "green", "blue", "blue");
print_r(array_keys($array, "blue"));

//array array_values ( array $input )   // 返回数组中所有的值
//例如：
$array = array("size" => "XL", "color" => "gold");
print_r(array_values($array));


//随机
//mixed array_rand ( array $input [, int $num_req = 1 ] )  //从数组中随机取出一个或多个单元 
//例如：
$input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
$rand_keys = array_rand($input, 2);
echo $input[$rand_keys[0]] . "\n";
echo $input[$rand_keys[1]] . "\n";

//bool shuffle ( array &$array )    //将数组打乱
//例如：
$numbers = range(1, 20);
shuffle($numbers);
foreach ($numbers as $number) {
    echo "$number ";
}


//存在判断：
//bool in_array ( mixed $needle , array $haystack [, bool $strict = FALSE ] ) //检查数组中是否存在某个值
//例如：
s = array("Mac", "NT", "Irix", "Linux");
if (in_array("Irix", $os)) {
    echo "Got Irix";
}

//bool array_key_exists ( mixed $key , array $search )  //检查给定的键名或索引是否存在于数组中
//例如：
$search_array = array('first' => 1, 'second' => 4);
if (array_key_exists('first', $search_array)) {
    echo "The 'first' element is in the array";
}


//合并
$arr1 = array()
$arr2 = array()
$arr = $arr1 + $arr2;   //数组合并

//array array_merge ( array $array1 [, array $... ] ) //合并一个或多个数组
//例如：
$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
$result = array_merge($array1, $array2);
print_r($result);
//Array
//(
//    [color] => green
//    [0] => 2
//    [1] => 4
//    [2] => a
//    [3] => b
//    [shape] => trapezoid
//    [4] => 4
//)


//差集
//array array_diff ( array $array1 , array $array2 [, array $... ] )   //计算数组的差集(对比返回在 array1 中但是不在 array2 及任何其它参数数组中的值。)
//array array_udiff ( array $array1 , array $array2 [, array $ ... ], callable $data_compare_func ) // 用回调函数比较数据来计算数组的差集
//例如：
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");
$result = array_diff($array1, $array2);

print_r($result);

//array array_diff_key ( array $array1 , array $array2 [, array $... ] ) // 根据 array1 中的键名和 array2 进行比较，返回不同键名的项。 本函数和 array_diff() 相同只除了比较是根据键名而不是值来进行的。 
//例如：
$array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
$array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);

var_dump(array_diff_key($array1, $array2));

//array array_diff_ukey ( array $array1 , array $array2 [, array $ ... ], callable $key_compare_func ) //用回调函数对键名比较计算数组的差集

//array array_diff_assoc ( array $array1 , array $array2 [, array $... ] ) // 带索引检查计算数组的差集 (返回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。注意和 array_diff() 不同的是键名也用于比较。)
//例如：
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "yellow", "red");
$result = array_diff_assoc($array1, $array2);
print_r($result);


//过滤
//例如：
//array_map('unlink', array_filter(glob('*'), 'is_file'));     // 删除文件(不包含目录)
//array_filter(glob('*'), 'fun_name');                         // 过滤出fun_name这个函数返回为true的所有元素；


//滤重
//例如：
//array_unique($a);


//对指定的数组，执行指定的函数：
//例如:
//array_map('rmdir', glob('*', GLOB_ONLYDIR));                 // 删除目录下所有空目录


//array遍历的方法汇总 ：
//foreach ($arr as $v) {
//}

//foreach ($arr as $k => $v) {
//}

//while
//for

//each_list（current__next__prev__end）


?>
