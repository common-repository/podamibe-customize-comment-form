jQuery(document).ready( function($) {
	/**
	* Scripts for tab view
	* Preview the leaved tab if browser is not closed
	*/
	jQuery('ul.tabs li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');
		sessionStorage.setItem("activeTab",tab_id);
		jQuery('ul.tabs li').removeClass('current');
		jQuery('.tab-content').removeClass('current');

		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
	});

	var active_tab = sessionStorage.getItem("activeTab");

	if(!active_tab){
		jQuery('ul.tabs li[data-tab="tab-1"]').trigger('click');
	}

	if(active_tab){
		jQuery('ul.tabs li[data-tab='+active_tab+']').trigger("click");
	}

} );
