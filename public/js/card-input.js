(function( $ ){

    $.fn.extend({
        credit: function ( args ) {
            $(this).each(function (){
                // Set defaults
                var defaults = {
                    auto_select:true
                }

                // Init user arguments
                var args = $.extend(defaults,args);

                // global var for the orginal input
                var credit_org = $(this);

                // Hide input if css was not set
                credit_org.css("display","none");

                // Create credit control holder
                var credit_control = $('<div></div>',{
                    class: "credit-input"
                });

                // Add credit cell inputs to the holder
                for ( i = 0; i < 4; i++ ) {
                    credit_control.append(
                        $("<input />",{
                            class: "credit-cell  form-control col-xs-2",
                            placeholder: "0000",
                            maxlength: 4
                        })
                    );
                }

                // Print the full credit input
                credit_org.after( credit_control );

                // Global var for credit cells
                var cells = credit_control.children(".credit-cell");

                /**
                 * Set key press event for all credit inputs
                 * this function will allow only to numbers to be inserted.
                 * @access public
                 * @return {bool} check if user input is only numbers
                 */
                cells.keypress(function ( event ) {
                    // Check if key code is a number
                    if ( event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57) ) {
                        // Key code is a number, the `keydown` event will fire next
                        return false;
                    }
                    // Key code is not a number return false, the `keydown` event will not fire
                    return true;
                });

                /**
                 * Set key down event for all credit inputs
                 * @access public
                 * @return {void}
                 */
                cells.keydown(function ( event ) {
                    // Check if key is backspace
                    var backspace = ( event.keyCode == 8 );
                    // Switch credit text length
                    switch( $(this).val().length ) {
                        case 4:
                            // If key is backspace do nothing
                            if ( backspace ) {
                                return;
                            }
                            // Select next credit element
                            var n = $(this).next(".credit-cell");
                            // If found
                            if (n.length) {
                                // Focus on it
                                n.focus();
                            }
                            break;
                        case 0:
                            // Check if key down is backspace
                            if ( !backspace ) {
                                // Key is not backspace, do nothing.
                                return;
                            }
                            // Select previous credit element
                            var n = $(this).prev(".credit-cell");
                            // If found
                            if (n.length) {
                                // Focus on it
                                n.focus();
                            }
                            break;
                    }
                });

                // On cells focus
                cells.focus( function() {
                    // Add focus class
                    credit_control.addClass('c-focus');
                });

                // On focus out
                cells.blur( function() {
                    // Remove focus class
                    credit_control.removeClass('c-focus');
                });

                /**
                 * Update orginal input value to the credit card number
                 * @access public
                 * @return {void}
                 */
                cells.keyup(function (){
                    // Init card number var
                    var card_number = '';
                    // For each of the credit card cells
                    cells.each(function (){
                        // Add current cell value
                        card_number = card_number + $(this).val();
                    });
                    // Set orginal input value
                    credit_org.val( card_number );
                    $('#credit_card_number').val(card_number + $(this).html());
                    getCardType(card_number);
                });


                if ( args["auto_select"] === true ) {
                    // Focus on the first credit cell input
                    credit_control.children(".credit-cell:first").focus();
                }

            });

        }
    });

})(jQuery);


function getCardType(number){
    visa_regex = new RegExp('^4[0-9]{0,15}$'),

    // MasterCard
    mastercard_regex = new RegExp('^5$|^5[1-5][0-9]{0,14}$'),

    // American Express
    amex_regex = new RegExp('^3$|^3[47][0-9]{0,13}$'),

    // Diners Club
    diners_regex = new RegExp('^3$|^3[068]$|^3(?:0[0-5]|[68][0-9])[0-9]{0,11}$'),

    //Discover
    discover_regex = new RegExp('^6$|^6[05]$|^601[1]?$|^65[0-9][0-9]?$|^6(?:011|5[0-9]{2})[0-9]{0,12}$'),

    //JCB
    jcb_regex = new RegExp('^2[1]?$|^21[3]?$|^1[8]?$|^18[0]?$|^(?:2131|1800)[0-9]{0,11}$|^3[5]?$|^35[0-9]{0,14}$');
    var cur_val = number;
    var img_path = 'nothing';
    // checks per each, as their could be multiple hits
    if ( cur_val.match(visa_regex) ) {
        img_path = 'Visa' ;
    }

    if ( cur_val.match(mastercard_regex) ) {
        img_path = 'MasterCard' ;
    }

    if ( cur_val.match(amex_regex) ) {
        img_path = 'Amex' ;
    }

    if ( cur_val.match(diners_regex) ) {
        img_path = 'DinersClub' ;
    }

    if ( cur_val.match(discover_regex) ) {
        img_path = 'Discover' ;
    }

    if ( cur_val.match(jcb_regex) ) {
        img_path = 'JCB' ;
    }
    var storage = '../payment_method_icons/light/';
    var full_path = storage+img_path+'.png';

    $('#card_image').attr('src', full_path);

}
jQuery(function ( $ ){
    $(".credit").credit();
});