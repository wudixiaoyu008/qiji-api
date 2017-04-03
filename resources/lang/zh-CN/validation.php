<?php
return [
	'required'   => ':attribute 不能为空',
	'in'         => ':attribute 只能为: :values',
  'numeric'    => ':attribute 只能为数字',
	'parameters' => [
		'invalid'  => '参数不合法'
	],
	'forbidden'  => [
		'use'   => '禁止使用',
		'login' => '禁止登录'
	],
  'regex' => ':attribute 只能为数字或者符号-',
  'digits'=>':attribute 只能是 :digits 位数字'
];
