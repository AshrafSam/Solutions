<?php /* Smarty version Smarty-3.0.7, created on 2011-07-09 21:00:22
         compiled from "./style/templates/elnaobas/branch/show.html" */ ?>
<?php /*%%SmartyHeaderCode:43174e1897365a0d24-46255218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a0eb5d63618a05bfc2bbf939684c903c49375c5' => 
    array (
      0 => './style/templates/elnaobas/branch/show.html',
      1 => 1310233586,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '43174e1897365a0d24-46255218',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
			<h2>الفروع الموجودة</h2>

			<table>
				<tr class="head">
					<td style="width: 200px">اسم الفرع</td>
					<td style="width: 100px">مواد الفرع</td>
					<td style="width: 100px">أساتذة الفرع</td>
					<td style="width: 150px">خيارات</td>
				</tr>

				<?php  $_smarty_tpl->tpl_vars['branch'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('branches')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['branch']->key => $_smarty_tpl->tpl_vars['branch']->value){
?>
				<tr>
					<td><?php echo $_smarty_tpl->getVariable('branch')->value->branchtitle;?>
</td>
					<td><a href="<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/subject/show/?bid=<?php echo $_smarty_tpl->getVariable('branch')->value->branchid;?>
"><?php if ($_smarty_tpl->getVariable('branch')->value->subjects_num===null){?>0<?php }else{ ?><?php echo $_smarty_tpl->getVariable('branch')->value->subjects_num;?>
<?php }?></a></td>
					<td><a href="<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/teacher/show/?bid=<?php echo $_smarty_tpl->getVariable('branch')->value->branchid;?>
"><?php if ($_smarty_tpl->getVariable('branch')->value->teachers_num===null){?>0<?php }else{ ?><?php echo $_smarty_tpl->getVariable('branch')->value->teachers_num;?>
<?php }?></a></td>
					<td><a href="<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/branch/edit/?bid=<?php echo $_smarty_tpl->getVariable('branch')->value->branchid;?>
">تعديل</a> - <a href="<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/branch/delete/?bid=<?php echo $_smarty_tpl->getVariable('branch')->value->branchid;?>
">حذف</a></td>
				</tr>
				<?php }} ?>
			</table>