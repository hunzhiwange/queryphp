<?php

function aop_add_before($node, $testpoint1) {
    var_dump($node);
    var_dump($testpoint1);
}

$testpoint1 = function () {
    echo "这是前切点测试函数：";
};
aop_add_before('testFunc1()', $testpoint1);