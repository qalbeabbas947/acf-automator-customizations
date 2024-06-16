(function( $ ) { 'use strict';

    $( document ).ready( function() {

        var AAI_BACKEND = {

            init: function() {
                this.addUserOnEmailList();
                this.addEmailIntoField();
            },

            /**
             * Add email into field
             */
            addEmailIntoField: function() {

                $( document ).on( 'change', '.aai-select-box', function() {
                    console.log(UncannyAutomator._recipe.actions.items[0].fields.EMAILTO                    );
                    var oldval = UncannyAutomator._recipe.actions.items[0].fields.EMAILTO.value;
                    let self = $(this);
                    let val = self.val();
                    var rand = Math.floor(Math.random() * 10000000);
                    var email = rand + 'abbas@gmail.com';
                   // console.log(email);
                    let parent = self.parents( '.form-element' );
                    //parent.find( '.CodeMirror-line' ).append( ", " + email ).trigger('change');
                   // console.log(parent.find( '.CodeMirror-line' ));
                    let post_id = self.parents('.uap-item--instant').data('id');
                    // //parent.find( '.CodeMirror-line' ).trigger('change');
                    // //$('.item-title__token--filled').trigger('click');
                    var e1 = jQuery.Event("keypress");
                    e1.which = 13;
                    e1.keyCode = 13;
                    parent.find( '.CodeMirror-line' ).trigger(e1);
                    for( let i=64;i<129;i++ ) {
                        e1 = jQuery.Event("keypress");
                        e1.which = i;
                        //e1.keyCode = i;
                        parent.find( '.CodeMirror-line' ).trigger(e1); 
                        console.log(i)
                    }
                    e1 = jQuery.Event("keypress");
                    e1.which = 13;
                    e1.keyCode = 13;
                    parent.find( '.CodeMirror-line' ).trigger(e1);

                    UncannyAutomator._recipe.actions.items[0].fields.EMAILTO.value = oldval + ", " + email;
                    parent.find( '.CodeMirror-line' ).html(oldval + ", " + email);
                    parent.find( '.CodeMirror-cursor' ).css( 'left', parseInt( parent.find( '.CodeMirror-cursor' ).css( 'left' )) + (email.length * 3)+8);
                    
                   // document.querySelectorAll(".item-title__token--filled")[0].click();
                    // parent.find( '.CodeMirror-line' ).trigger(e1);
                    // if( val ) {
                    //     $.ajax({
                    //         url: ajaxurl,
                    //         dataType: 'json',
                    //         data: {
                    //             action: 'acf_automator_email_list', 
                    //             post_id: post_id,
                    //             user_id:  val
                    //         },
                    //         success: function ( response ) {
                    //             console.log(response);
                    //             document.querySelectorAll(".item-title__token--filled")[0].click();
                    //         }
                    //     });
                    // }
                    // let parent = self.parents( '.form-element' ); document.querySelectorAll(".item-title__token--filled")[0].click();

                    // let text = parent.find( '.CodeMirror-line' ).children().first().text();
                    // if( text ) {
                    //     parent.find( '.CodeMirror-line .CodeMirror-widget' ).last().after( '<span class="CodeMirror-widget" role="presentation" cm-ignore-events="true"><span class="uap-token"><span class="uap-token__icon"><img src="http://localhost/handbook/wp-content/plugins/uncanny-automator/src/integrations/common/img/common-icon.svg"></span><span class="uap-token__name">asad</span></span></span>' );
                    //     // if( firstWidgetSpan.length > 0 ) {
                    //     //     var currentHtml = firstWidgetSpan.html();
                    //     //     firstWidgetSpan.html(currentHtml + ',youx hear');
                    //     // } else {
                    //     //     parent.find( '.CodeMirror-line' ).html( '<span role="presentation" style="padding-right: 0.1px;">asad</span>' );     
                    //     // }
                    // }
                } );
            },

            /**
             * add user on email list
             */
            addUserOnEmailList: function() {
                
                $( document ).on( 'click', '.form-variable__toggle', function() {

                    let self = $(this);
                    let parent = self.parents( '.form-element' );
                    let emailTo = parent.find( 'label' ).attr( 'for' );
                    let extractedPart = emailTo.split('__')[0];
                    if( 'EMAILTO' == extractedPart ) {

                        if( ! parent.find( '.form-element select' ).length > 0 ) {
                            $( '.form-variable__filter .form-element .form-checkbox' ).after( $( '.aai-main-wrapper' ).html() );
                        }
                    }
                } );
            },
        };
        AAI_BACKEND.init();
    });
})( jQuery );