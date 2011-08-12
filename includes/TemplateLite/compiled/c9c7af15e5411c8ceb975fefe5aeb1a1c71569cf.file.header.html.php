<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 22:56:58
         compiled from "./style/templates/elnaobas/header.html" */ ?>
<?php /*%%SmartyHeaderCode:241804e1f4a0a7d7a32-53658508%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9c7af15e5411c8ceb975fefe5aeb1a1c71569cf' => 
    array (
      0 => './style/templates/elnaobas/header.html',
      1 => 1310673416,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '241804e1f4a0a7d7a32-53658508',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="ar" lang="ar" dir="rtl">
	<head>
		<title>دبّرني | التحكم</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="cache-control" content="no-cache" />
		
		<base href="<?php echo $_smarty_tpl->getVariable('root_path')->value;?>
" />
		<style type="text/css">
			@import url('./style/elnaobas_style.css');
		</style>
	</head>
	
	<body>
		<div id="topbar">
			<a href="">الرئيسية</a> -
			<a href="">تصفح الموقع</a>
		</div>
		
		<div id="header">
			دبّرني - التحكم
		</div>
		
		<?php $_template = new Smarty_Internal_Template("./".($_smarty_tpl->getVariable('controller')->value)."/sidebar.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
		<div id="contents">