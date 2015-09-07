<?php 
	$metavalues = $row['column_meta_fields'];	    
?>
<?php if(!empty ($metavalues[0]['column_meta_name'])) : ?>
    <div class="rehub_meta_fields">                                 
        <?php $count=1; foreach ($metavalues as $metavalue) { ?>
        <?php $field_value = get_post_meta(get_the_ID(), $metavalue['column_meta_name'], true) ;?> 
        <?php $field_type = $metavalue['column_meta_type'] ;?>
        <?php $value_font_size = ($metavalue['column_meta_value_size'] !='') ? 'font-size:'.$metavalue["column_meta_value_size"].'px !important;' : ''; ?>
        <?php $value_font_color = ($metavalue['column_meta_value_color'] !='') ? 'color:'.$metavalue["column_meta_value_color"].' !important;' : ''; ?>               
        <?php $value_font_style = (($metavalue['column_meta_value_color'] !='' || $metavalue['column_meta_value_size'] !='') && $metavalue['column_customize'] =='1') ? ' style="'.$value_font_size.$value_font_color.'"' : ''; ?>       
    	<?php if($field_type =='checkbox') : ?>
            <div class="rehub_meta_field rehub_field_<?php echo $count; ?>">
                <?php $field_value_check = ($field_value =='1' || $field_value =='on') ? '<i class="fa fa-check"></i>' : '' ?>
                <span class="rehub_meta_field_icon"<?php echo $value_font_style; ?>><?php echo $field_value_check ;?></span>
                <span class="rehub_meta_field_value hidden"><?php echo $field_value; ?></span>
            </div>
    	<?php else : ?>
            <?php $field_value_exist = ($field_value =='') ? ' disabled' : '' ?>
            <div class="rehub_meta_field rehub_field_<?php echo $count; ?><?php echo $field_value_exist ; ?>">
                <span class="rehub_meta_field_value"<?php echo $value_font_style; ?>><?php echo $field_value; ?></span>
            </div>
    	<?php endif; ?>    
        <?php $count++; ?>    
        <?php } ?>                        
    </div>
<?php endif; ?>
