<?php /* Smarty version Smarty-3.0.7, created on 2011-07-09 18:34:37
         compiled from "./style/templates/elnaobas/branch/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:123924e18750da362e2-45648742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f83937c168d29b8e0c8f9acebd4559ce9f933a26' => 
    array (
      0 => './style/templates/elnaobas/branch/edit.html',
      1 => 1310225664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '123924e18750da362e2-45648742',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
			<h2>فرع جديد</h2>
			
			<form method="post">
				<table>
					<tr>
						<td class="head" style="width: 200px">اسم الفرع</td>
						<td><input type="text" name="branchtitle" value="<?php echo $_smarty_tpl->getVariable('branch')->value->branchtitle;?>
" /></td>
					</tr>
					
					<tr>
						<td></td>
						<td><input type="submit" class="button" value=" تعديل " /></td>
					</tr>
				</table>
			</form>