<?php /* Smarty version 2.6.28, created on 2015-04-29 15:01:56
         compiled from L16.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'L16.tpl', 36, false),array('function', 'html_options', 'L16.tpl', 58, false),array('function', 'html_checkboxes', 'L16.tpl', 66, false),array('modifier', 'default', 'L16.tpl', 36, false),array('modifier', 'strip', 'L16.tpl', 43, false),array('modifier', 'escape', 'L16.tpl', 43, false),)), $this); ?>
<!DOCTYPE HTML>
<HTML>
   <HEAD>
      <TITLE>Lesson 16</TITLE>
    
          <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
     
      <script src="./javascript/ads.js"></script>
      
   </HEAD>
   <body>
       
       
       
       
       <div class="results"></div>
       <form class="form-horizontal" id="adsform" method="POST" >
 <div class="container col-lg-5 col-md-8 col-sm-8 col-lg-offset-3 col-md-offset-1 col-sm-offset-1"> 
     
    <div class="form-group">
    <div class="col-sm-offset-5 col-sm-7 ">
      <div class="radio">

        <?php echo smarty_function_html_radios(array('id' => 'inlineRadio1','name' => 'private','options' => $this->_tpl_vars['radios'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['adToReturn']->private)) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0'))), $this);?>

              </div>
       </div>
    </div>        
    <div class="form-group">
        <label for="seller_name" class="col-sm-5 control-label">Ваше имя *</label>
            <div class="col-sm-7">
            <input  type="text" class="form-control input-sm" id="seller_name" maxlength="20" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['auToReturn']->seller_name)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="seller_name">
            </DIV>
    </div>
    <div class="form-group"> 
        <label class="col-sm-5 control-label" for="email">Электронная почта *</label>
        <div class="col-sm-7">
        <input class="form-control input-sm" id="email" type="email" maxlength="50" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['auToReturn']->email)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="email">
        </div>
    </DIV>
        
    <div class="form-group">
            <LABEL class="col-sm-5 control-label" for="authors">Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
             <div class="col-sm-7">
            <select id="authors" class="form-control input-sm" title="список авторов" name="saved_email"> 
                 <option value="0">&nbsp;</option>
                  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['checkboxAuthors'],'selected' => $this->_tpl_vars['adToReturn']->author_id), $this);?>
 
            </select>
             </div>
    </div>  
    
     <div class="form-group">
        <div class="checkbox">
            <div class="col-sm-offset-5 col-sm-7">
            <?php echo smarty_function_html_checkboxes(array('name' => 'allow_mails','id' => 'allow_mails','values' => '1','output' => 'Я не хочу получать вопросы по объявлению по e-mail','selected' => $this->_tpl_vars['adToReturn']->allow_mails,'separator' => "<br />"), $this);?>

            </div>
        </div>
     </DIV>
        
    <div class="form-group"> 
        <label class="col-sm-5 control-label" for="phone">Номер телефона</label>
        <div class="col-sm-7">
        <input class="form-control input-sm" type="tel" id="phone"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->phone)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="phone">
        </div>
    </div>
        
    <div class="form-group"> 
       <label  class="col-sm-5 control-label" for="city">Город</label> 
               <div class="col-sm-7">
       <select class="form-control input-sm" id="city" title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['cities'],'selected' => $this->_tpl_vars['adToReturn']->location_id), $this);?>

         </select>
         </div>
    </div>
         
    <div class="form-group"> 
        <label class="col-sm-5 control-label" for="ctgs">Категория</label> 
        <div class="col-sm-7">
            <select class="form-control input-sm" id="ctgs" name="category_id">
                <option value="">-- Выберите категорию --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['categories'],'selected' => $this->_tpl_vars['adToReturn']->category_id), $this);?>

            </select> 
        </div>
    </div>
            
    <div class="form-group">
        <label class="col-sm-5 control-label" for="title">Название объявления *</label> 
           <div class="col-sm-7">
        <input class="form-control input-sm" id="title" type="text" maxlength="30" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->title)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="title">
           </div>
    </div>
           
    <div class="form-group"> 
        <label  class="col-sm-5 control-label" for="description">Описание объявления</label>
         <div class="col-sm-7">
        <textarea class="form-control input-sm" maxlength="500" name="description" id="description"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['adToReturn']->description)) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
</textarea>
         </div>
    </div>
         
    <div class="form-group"> 
        <label  class="col-sm-5 control-label" for="price">Цена</label>
         <div class="col-sm-7">
             <div class="input-group">
              <span class="input-group-addon">$</span>
        <input class="form-control input-sm" id="price" type="number" maxlength="9"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['adToReturn']->price)) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')))) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'utf-8') : smarty_modifier_escape($_tmp, 'htmlall', 'utf-8')); ?>
" name="price" >
             </DIV>
         </div>
    </div>
             
    <div class="form-group"> 
        <input type="hidden" id="id" value="<?php echo $this->_tpl_vars['adToReturn']->id; ?>
" name="id" >
        <div class="col-sm-offset-5 col-sm-7">
            <input class="submit_button btn btn-success btn-large"" type="submit" value="Отправить" name="main_form_submit"  > </DIV>
    </div>
            
    <div class="form-group">
    <div class='notice'>
        <?php if ($this->_tpl_vars['notice']): ?>
        <p class="col-sm-offset-5 col-sm-7 bg-warning"><?php echo $this->_tpl_vars['notice']->getNotice(); ?>
</p>
        <?php endif; ?>
    </div>
    </div>
 </DIV>
</form>
 
    <div style="position: fixed;bottom: 0;right: 0;width: 350px" class="text-center">
        
    <div class="alert" style="position: relative;display: none;" >
        <div id="container_delete" style="display:inline-block"></div>&nbsp;
        <button type="button" class="close" onclick="$('div.alert:has(#container_delete)').hide();"><span aria-hidden="true">&times;</span></button>
        
        
</div>
        <div class="alert alert-warning" style="position: relative;display: none;" >
        <div id="container_warning" style="display:inline-block"></div>&nbsp;
        <button type="button" class="close" onclick="$('div.alert:has(#container_warning)').hide();"><span aria-hidden="true">&times;</span></button>
        
        
</div>
    </div>
    
    

  <div class="container_ads container col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">  
  </div>
   </body>
</HTML>