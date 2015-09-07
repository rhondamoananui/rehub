<?php 
    $post_type = $data_source = $orderby = $order = $show = $ajax = $pag_pos = $tax = $sortid ='';
    extract(shortcode_atts(array(
        'post_type' => '',
        'data_source' => '',
        'orderby' => '',
        'order' => 'DESC',
        'show' => '9',
        'ajax' => '',
        'pag_pos' => '',
        'tax' => '',
        'sortid' => '', 
    ), $atts));

    $sort_panel = ($sortid !='') ? ' panel_id='.intval($sortid).'' : '';
    $out = 'template='.$data_source.' post_type='.$post_type.' orderby='.$orderby.' order='.$order.' per_page='.$show.' pagination='.$pag_pos.' '.$tax.$sort_panel.'';
    $wooout = 'columns=3 orderby='.$orderby.' order='.$order.' per_page='.$show.' pagination='.$pag_pos.' '.$tax.'';
    if($data_source !='woocommerce') {
        if ($ajax !='') {
            echo do_shortcode('[mdf_results_by_ajax shortcode="mdf_custom '.$out.'" animate=0]');
        }
        else {
            echo do_shortcode('[mdf_custom '.$out.']');
        }
    }
    else {
        if ($ajax !='') {
            echo do_shortcode('[mdf_results_by_ajax shortcode="mdf_products '.$wooout.'" animate=0]');
        }
        else {
            echo do_shortcode('[mdf_products '.$wooout.']');
        }
    }
        
?>

