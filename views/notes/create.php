<?php
	$info = $this->info;
	$item_info = $this->item_info;
?>
<style>
	form input{
		font-size: 20px;
	}
</style>
<h3><?php echo (isset($item_info[0]['name']))?str_replace("_"," ",$item_info[0]['name']).' #'.$item_info[0]['id']:'Fixture'; ?> Note</h3>
<form action="" method="POST">
        <div>
		Note Description
		<div>
			<textarea name="notes[description]"><?php echo $info['description']; ?></textarea>
		</div>
	</div>
	<?php if(isset($info['sub_type'])){ ?>
	<input type="hidden" name="notes[sub_type]" value="<?php echo $info['sub_type']; ?>"/>
	<input type="hidden" name="notes[sub_type_id]" value="<?php echo $info['sub_type_id']; ?>"/>
	<?php }else{ ?>
	<select name="notes[sub_type]" id="notes-sub-type">
	    <option value="fixture">Fixture</option>
	    <option value="panel">Panel</option>
	    <option value="property">Property</option>
	</select>
	<select name="notes[sub_type_id]" id="notes-sub-type-id"></select>
	<script>
    $.ajax(
        {
            url: "/notes/create/?ajax=1",
            type: "POST",
            data: $('#notes-sub-type').val(),
            success: function(html){
                var json = jQuery.parseJSON(html);
                var options = '<options value="[value]">[name]</option>';
                var html_info = '';
                for(a in json){
                    var option = options;
                    option.replace('[value]',json[a].id);
                    option.replace('[name]',json[a].name);
                    html_info += option;
                }
                $('#notes-sub-type-id').html(html_info);
            }
        }
    );
</script>
	<?php }?>
	<input type="hidden" name="notes[user_id]" value="<?php echo $info['user_id']; ?>"/>
	<input name="submit" value="submit" type="submit" />
</form>
