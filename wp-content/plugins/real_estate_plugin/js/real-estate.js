jQuery(document).ready(function($) {
            
       /*AJAX Filter Button*/
        $("#house-filter-submit").on('click', function(e){
                e.preventDefault();
                                
                var form_data = {
                    number_of_floors : $('.house-filter-form select[name="number_of_floors"]').val(),
                    type             : $('.house-filter-form select[name="type"]').val(),
                    ecology          : $('.house-filter-form select[name="ecology"]').val(),
                    rooms            : $('.house-filter-form select[name="rooms"]').val(),
                    balcony          : $('.house-filter-form select[name="balcony"]').val(),
                    bathroom         : $('.house-filter-form select[name="bathroom"]').val()
                };
                
                $("#house-filter-submit").data('current_query', form_data);
                
                house_filter_query( form_data, real_estate_ajax );
        });
                        
        /*AJAX Pagination Previous*/
        $(".house-filter").on('click', '.apartments-pagination .prev', function(e){
                e.preventDefault();
                
                var form_data = $("#house-filter-submit").data('current_query');
                
                form_data.offset = $(this).data('offset');
                
                house_filter_query( form_data, real_estate_ajax );
                
        });
        
        /*AJAX Pagination Next*/
        $(".house-filter").on('click', '.apartments-pagination .next', function(e){
                e.preventDefault();
                                
                var form_data = $("#house-filter-submit").data('current_query');
                
                form_data.offset = $(this).data('offset');
                
                house_filter_query( form_data, real_estate_ajax );
                
        });
        
        /*AJAX Query*/
        function house_filter_query( form_data, real_estate_ajax ){
                var ajaxdata = {
                    action           : 'filter_btn',
                    nonce_code       : real_estate_ajax.nonce,
                    form_data        : form_data
                };
                                
                $.post( real_estate_ajax.url, ajaxdata, function( response ) {
                        if(!response){
                                response = '<p>Ничего не найдено</p>';
                        }
                        $("#house-filter-output").html( response );
                });                
        }
});


