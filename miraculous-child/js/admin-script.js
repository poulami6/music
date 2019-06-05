jQuery(document).ready(function(){
    jQuery('.cb-select-all').on('click',function(){
        
        var id_name = jQuery(this).attr('id');
        if(this.checked){
            jQuery('.cb-select-'+id_name).each(function(){
                this.checked = true;
            });
        }else{
             jQuery('.cb-select-'+id_name).each(function(){
                this.checked = false;
            });
        }
    });
    
    jQuery('.checkbox').on('click',function(){
        
        var data_id = jQuery(this).attr("data-id");

        if(jQuery('.cb-select-'+data_id+':checked').length == jQuery('.cb-select-'+data_id).length){
            jQuery('#'+data_id).prop('checked',true);
        }else{
            jQuery('#'+data_id).prop('checked',false);
        }
    });

    function display_admin_playlist($playlist_key) {
        alert('test');
        alert($playlist_key);
        
    }
});