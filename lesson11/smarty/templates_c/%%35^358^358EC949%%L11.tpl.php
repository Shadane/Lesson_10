<?php /* Smarty version 2.6.28, created on 2015-04-03 12:24:38
         compiled from L11.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'L11.tpl', 12, false),array('function', 'html_options', 'L11.tpl', 27, false),array('function', 'html_checkboxes', 'L11.tpl', 33, false),array('modifier', 'default', 'L11.tpl', 12, false),array('modifier', 'strip', 'L11.tpl', 18, false),array('modifier', 'escape', 'L11.tpl', 18, false),)), $this); ?>
<!DOCTYPE HTML>
<HTML>
   <HEAD>
      <TITLE>Lesson 11</TITLE>
      <meta charset="utf-8">
      <link type="text/css" rel="stylesheet" href="./css/style.css" />

   </HEAD>
   <body>
<form method="post">
    <div class="radios">
        <?php echo smarty_function_html_radios(array('name' => 'private','options' => $this->_tpl_vars['radios'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['adToReturn']->private)) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0'))), $this);?>

    </div> 
    <div> 
        <label>
            Ваше имя *
        </label>
        <input type="text" maxlength="20" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->seller_name)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="seller_name">
    </div>
    <div> 
        <label>Электронная почта *</label>
        <input type="text" maxlength="50" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->email)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="email">
        <div>
            <LABEL>Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
            <select  title="список авторов" name="saved_email"> 
                 <option value="0">&nbsp;</option>
                  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['checkboxAuthors'],'selected' => $this->_tpl_vars['adToReturn']->author_id), $this);?>
 
            </select>
        </div>  
    </div>
     
    <div class="allow_mails">
            <?php echo smarty_function_html_checkboxes(array('name' => 'allow_mails','values' => '1','output' => 'Я не хочу получать вопросы по объявлению по e-mail','selected' => $this->_tpl_vars['adToReturn']->allow_mails,'separator' => "<br />"), $this);?>

    </div>
    <div> 
        <label>Номер телефона</label>
        <input type="text"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->phone)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="phone">
    </div>
    <div> 
       <label >Город</label> 
       <select title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['cities'],'selected' => $this->_tpl_vars['adToReturn']->location_id), $this);?>

         </select>
    </div>
    <div> 
        <label>Категория</label> 
            <select name="category_id">
                <option value="">-- Выберите категорию --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['categories'],'selected' => $this->_tpl_vars['adToReturn']->category_id), $this);?>

            </select> 
    </div>
    <div>
        <label>Название объявления *</label> 
        <input type="text" maxlength="30" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->title)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="title">
    </div>
    <div> 
        <label>Описание объявления</label>
        <textarea maxlength="500" name="description" ><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->description)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</textarea>
    </div>
    <div> 
        <label >Цена</label>
        <input type="text" maxlength="9"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['adToReturn']->price)) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')))) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="price" >                                                         
    </div>
    <div> 
        <input type="hidden" value="<?php echo $this->_tpl_vars['adToReturn']->return_id; ?>
" name="return_id" >
        <input class="submit_button" type="submit" value="Отправить" name="main_form_submit"  > </div>
    <div class='notice'>
        <?php if ($this->_tpl_vars['notice']): ?>
        <LABEL><?php echo $this->_tpl_vars['notice']->getNotice(); ?>
</LABEL>
        <?php endif; ?>
    </div>
</form>
    
  <table>
           <tr>
               
                <td> |  Название объявления </td>
                <td>  |  Цена </td>
                <td>  |  Имя </td>
                <td>  |  Удалить | </td>
           </tr>
<?php if ($this->_tpl_vars['ads']): ?>
    <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['arr']):
?>
<?php $this->assign('authorId', $this->_tpl_vars['arr']->getAuthor_id()); ?>
        <tr>
            <td> |  <a href="?formreturn=<?php echo $this->_tpl_vars['key']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['arr']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</a></td>
            <td>  |  <?php echo ((is_array($_tmp=$this->_tpl_vars['arr']->getPrice())) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</td>
            <td>  |  <?php echo ((is_array($_tmp=$this->_tpl_vars['authors'][$this->_tpl_vars['authorId']]->getName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</td>
            <td>  |  <a href="?delentry=<?php echo $this->_tpl_vars['key']; ?>
">Удалить</a> |</td>
            </tr>  
           
    <?php endforeach; endif; unset($_from); ?>
 <?php else: ?>
 		</TABLE>
 		<div class='notice'>
 			<label >No active ads at the moment</label>
 			</div>
 		
<?php endif; ?>
  </TABLE>
   </body>
</HTML>