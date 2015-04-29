<?php /* Smarty version 2.6.28, created on 2015-04-29 15:18:23
         compiled from L16.table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'L16.table.tpl', 28, false),)), $this); ?>
 <script src="./javascript/table.js"></script> 

  <table class="table table-hover">
      <h2 class="sub-header text-center">Все объявления</h2>
      <THEAD>
           <tr>
               
                <th>Название объявления </td>
                <th>Цена </td>
                <th>Имя </td>
                <th>Действия</td>
           </tr>
      </THEAD>
      <tbody>
          
<?php if ($this->_tpl_vars['ads']): ?>
    <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['arr']):
?>
<?php $this->assign('authorId', $this->_tpl_vars['arr']->getAuthor_id()); ?>

<?php if (is_a ( $this->_tpl_vars['arr'] , 'CompanyAds' )): ?>
<?php $this->assign('trColor', 'warning'); ?>
<?php else: ?>
<?php $this->assign('trColor', ""); ?>
<?php endif; ?>


        <tr class="<?php echo $this->_tpl_vars['trColor']; ?>
 adlist">
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['arr']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['arr']->getPrice())) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
$</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['authors'][$this->_tpl_vars['authorId']]->getSeller_name())) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</td>
            <td><a class="edit btn btn-xs">Редактировать</a>&nbsp;&nbsp;<a class="delete btn btn-xs" id="<?php echo $this->_tpl_vars['key']; ?>
">Удалить</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
 <?php else: ?>
 		<div class='notice'>
 			<label >No active ads at the moment</label>
 			</div>
 		
<?php endif; ?>
   </TBODY>
  </TABLE>

