<?php /* Smarty version 2.6.28, created on 2015-03-01 11:06:30
         compiled from L9MySQLi.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'L9MySQLi.tpl', 11, false),array('function', 'html_options', 'L9MySQLi.tpl', 38, false),array('modifier', 'strip', 'L9MySQLi.tpl', 17, false),array('modifier', 'escape', 'L9MySQLi.tpl', 17, false),)), $this); ?>
<HTML>
   <HEAD>
      <TITLE>Lesson 9 MySQLi HW</TITLE>
          <style>  
            input.private <?php echo '{ margin-left:20px }'; ?>

            div <?php echo '{ width: 800px;}'; ?>

          </style>  
   </HEAD>
<form  method="post">
    <div style="margin-left:208px;margin-top:10px"> 
        <?php echo smarty_function_html_radios(array('name' => 'private','class' => 'private','options' => $this->_tpl_vars['radios'],'selected' => $this->_tpl_vars['showform_params']['return_private']), $this);?>

    </div> 
    <div style="margin-left:60px;margin-top:10px"> 
        <label>
            Ваше имя
        </label>
        <input style="margin-left:90px; width:230px" type="text" maxlength="20" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['showform_params']['namereturn'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
" name="seller_name">
    </div>
    <div style="margin-left:60px;  margin-top:10px"> 
        <label>Электронная почта</label>
        <input style="margin-left:27px; width:230px;" type="text"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['showform_params']['email_return'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
" name="email">
    </div>
    <div style="margin-left:217px;  margin-top:10px">
        <label> 
            <input type="checkbox" <?php echo $this->_tpl_vars['showform_params']['return_send_email']; ?>
 value="1" name="allow_mails">
            Я не хочу получать вопросы по объявлению по e-mail
        </label>
    </div>
    <div style="margin-left:60px;  margin-top:10px"> 
        <label>Номер телефона</label>
        <input style="margin-left:46px; width:230px" type="text"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['showform_params']['phonereturn'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
" name="phone">
    </div>
    <div style="margin-left:60px;  margin-top:10px"> 
       <label >Город</label> 
       <select style="margin-left:118px; width:230px;height:22px" title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['cities'],'selected' => $this->_tpl_vars['showform_params']['city']), $this);?>

         </select>
    </div>
    <div style="margin-left:60px;  margin-top:10px"> 
        <label for="fld_category_id" class="form-label">Категория</label> 
            <select style="margin-left:89px; width:230px;height:22px" name="category_id">
                <option value="">-- Выберите категорию --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['categories'],'selected' => $this->_tpl_vars['showform_params']['returncategory']), $this);?>

            </select> 
    </div>
    <div style="margin-left:60px;  margin-top:10px">
        <label>Название объявления</label> 
        <input style="margin-left:12px; width:230px;" type="text" maxlength="30" placeholder="<?php echo $this->_tpl_vars['showform_params']['notice_field_is_empty']; ?>
" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['showform_params']['returntitle'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
" name="title">
    </div>
    <div style="margin-left:60px;  margin-top:10px"> 
        <label style="position:absolute">Описание объявления</label>
        <textarea style="margin-left:162px; width:230px;height:70px;" maxlength="500" name="description" ><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['showform_params']['returndescription'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</textarea>
    </div>
    <div style="margin-left:60px;  margin-top:10px"> 
        <label >Цена</label>
        <input style="margin-left:124px; width:230px" type="text" maxlength="9"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['showform_params']['returnprice'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
" name="price" >                                                         
    </div>
    <div style="margin-left:221px;  margin-top:10px"> 
        <input type="hidden" value="<?php echo $this->_tpl_vars['showform_params']['return_id']; ?>
" name="return_id" >
        <input style="height:30px;font-weight: 700;color:white;border-radius: 3px;background: rgb(64,199,129);box-shadow: 0 -3px rgb(53,167,110) inset;transition: 0.2s;" type="submit" value="Отправить" name="main_form_submit"  > </div>
    </div>
</form>
    
  <table method="post" style="border: 1px solid black; margin-top:30px;margin-left: 80px">
        <div >
           <tr>
               
                <td> |  Название объявления </td>
                <td>  |  Цена </td>
                <td>  |  Имя </td>
                <td>  |  Удалить | </td>
           </tr>
         </div> 
         <div style="margin-left:111px;  margin-top:10px"> 
         </div>
<?php if ($this->_tpl_vars['ads_container']): ?>
    <?php $_from = $this->_tpl_vars['ads_container']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['arr']):
?>
        <tr>
            <td> |  <a href="?formreturn=<?php echo $this->_tpl_vars['key']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['arr']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</a></td>
            <td>  |  <?php echo ((is_array($_tmp=$this->_tpl_vars['arr']['price'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</td>
            <td>  |  <?php echo ((is_array($_tmp=$this->_tpl_vars['arr']['seller_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</td>
            <td>  |  <a href="?delentry=<?php echo $this->_tpl_vars['key']; ?>
">Удалить</a> |</td>
            </tr>  
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>