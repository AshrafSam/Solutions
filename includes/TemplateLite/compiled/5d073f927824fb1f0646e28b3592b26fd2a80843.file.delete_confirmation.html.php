<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 21:45:10
         compiled from "./style/templates/elnaobas/delete_confirmation.html" */ ?>
<?php /*%%SmartyHeaderCode:226204e1f393645e3a1-02150843%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d073f927824fb1f0646e28b3592b26fd2a80843' => 
    array (
      0 => './style/templates/elnaobas/delete_confirmation.html',
      1 => 1310234657,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '226204e1f393645e3a1-02150843',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
			<h2>تأكيد الحذف</h2>
			
			<form method="post">
				هل أنت متأكد من أنك تريد إتمام عملية الحذف؟
				<br />
				<input type="submit" class="button" value=" نعم " /> <input type="button" class="button" value=" لا " onclick="history.back(1)" />
			</form>