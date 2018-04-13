#!/usr/local/bin/php
<?php
/**
 * Created by PhpStorm.
 * User: danielqi
 * Date: 13/04/2018
 * Time: 10:58 AM
 */


/**
 * 生成可以并行执行的脚本
 * @param string $command 需要生成命令
 * @param int $start_id 开始处理的id
 * @param int $end_id  结束处理的id
 * @param int $per_num 每次执行的数量
 */
function main($command, int $start_id, int $end_id, int $per_num)
{
    $current_start_id = $start_id;
    $res = [];
    while ($current_start_id <= $end_id) {
        $current_end_id = $current_start_id + $per_num;
        $log_name = substr(md5($command), 0, 10) . "-{$current_start_id}-{$current_end_id}";
        $res[] = <<<EOF
{$command} {$current_start_id} {$current_end_id} 1>~/{$log_name}.suc.log 2>~/{$log_name}.err.log &
EOF;
        $current_start_id = $current_end_id;
    }
    echo implode("\n", $res), "\n";
}
$params = array_slice($argv,1);
main(...$params);