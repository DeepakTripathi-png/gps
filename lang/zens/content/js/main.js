//
// CITIZENSOLB (CITIZENSOLB)
//
// Self Executing Anonymous Function:
// -Enables use of private and public properties/methods
// -Also protects jQuery $ and undefined from conflicts
//
(function( CITIZENSOLB, $, undefined ) {

    // -----------------------------------------
    // PUBLIC
    //
    // Properties
    //
    CITIZENSOLB.property = '';


    // -----------------------------------------
    // PRIVATE
    //
    // Properties
    //
    var privateProperty = '',
        timeoutModalInterval,
        timeoutSecondsInterval;



    // -----------------------------------------
    // PRIVATE
    //
    // Methods
    //

    //
    // getUrlParam
    //
    // Utility function to snag a query string value when passed the parameter
    //
    function getUrlParam(name) {
        var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (!results) {
            return 0;
        }
        return results[1] || 0;
    }
    CITIZENSOLB.initTarget = function(target) {
		
		// trigger dropup is part of page body on incorrect password ("Contact Customer Service")
        $('.trigger-dropup-contact').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation(); // Prevents the link from trying to trigger a page-change
         
            // If the menu is already open and we're clicking on the link, close it to match other site behavior
            // Otherwise, open the menu and make sure all the other menus are closed
            var $dropup = $('#page-footer .contact').parent();
            if ($dropup.hasClass('dropup-active')) {
                $dropup.add($dropup.siblings()).removeClass('dropup-active');
            } else {
                $dropup.addClass('dropup-active').siblings().removeClass('dropup-active');
                $dropup.find('.contact').focus();
            }
        });
 
/*
        if(window.innerWidth > 880){
            stickyFooter();
        }
		*/
		
        // Tooltip Hover Intent

        if($(window).width() > 700 && !($("html").hasClass("lt-ie9"))) {
            $(target).find(".tooltip").hoverIntent(
                function(event) {
                    event.preventDefault();
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                }
		);  
        } else {
            $(target).find(".tooltip").on('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                $('.tooltip').removeClass('hover');
                $('.tooltip-box, .input-left').removeAttr('style');

                var height = $(this).addClass('hover').height(),
                    inputHeight = $(this).siblings('.input-left').css('top', '-' + height + 'px').height();
                $('.tooltip-box', this).css('top', (inputHeight + 10) + 'px');
            });
            $(document).on('blur', function(event) {
                $('.tooltip').removeClass('hover');
                $('.tooltip-box, .input-left').removeAttr('style');
            });
            $(document).on('click', function(event) {
                $('.tooltip').removeClass('hover');
                $('.tooltip-box, .input-left').removeAttr('style');
            });
        }

        
		 
        $('.mobile-help-trigger').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            $("#citizens-help").modal({
                containerId: 'help-modal',
                onShow: function() {
                    $('.simplemodal-wrap').prepend($('.modalCloseImg'));
                }
            });
        });

/*
 * 
 *  TJB: help part of HHF
 *
        $(document).on('click', '#close-overlay', function(event) {
            event.preventDefault();
            $('#help-modal-overlay').remove();
        });
*/
        
        // For fields with validation tooltips, validate on keyup
        function validateField() {
            var $formItem = $(this).parents('.form-item'),
                $rules = $formItem.find('.validation-tooltip .tooltip-content p'),
                val = $(this).val(),
                allValid = true;

            // Validate each rule
            $rules.each(function() {
            	var rule = new RegExp($(this).data('rule')),
            	    ruleID = $(this).attr('id');
            	
            	if ($(this).data('rule')) {
            	   $(this).find('img').remove(); // Delete any success/error images
                   valid = (val.match(rule) !== null); // If the regex doesn't match it's invalid
            	   addValidationImage(valid, $(this), ruleID);
            	
            	   allValid = valid ? allValid : valid; // Set allValid to false if valid is, otherwise keep the value
            	}
            });

            // Set the aria-invalid state
            $(this).attr('aria-invalid', !allValid);
            
            // If this is a password field, keep the confirm field "matchs" error in sync
            if ($(this).is('[type=password]')) {
                var $newPassword = $(this).parents('form').find('.new-password'),
                    $confirmPassword = $(this).parents('form').find('.confirm-password'),
                    $confirmRule = $confirmPassword.parent().find('.tooltip-content p'),
                    ruleID = $confirmRule.attr('id'),
                    valid = ($newPassword.val() === $confirmPassword.val());
                    
                $confirmRule.find('img').remove(); // Delete any success/error images
                addValidationImage(valid, $confirmRule, ruleID);

                // Set aria-invalid state
                $confirmPassword.attr('aria-invalid', !valid);
            }
            
            function addValidationImage(valid, $el, id) {
            	if (valid) {
            	   $el.prepend('<img src="efs/efs/grafx/tooltip-check.png" alt="Requirement has been filled" aria-describedby="' + id +'" />');
            	} else {
            	   $el.prepend('<img src="efs/efs/grafx/tooltip-x.png" alt="Error: Requirement has NOT been filled" aria-describedby="' + id +'" />');
            	}
            }
        }
        
        // Bind/unbind input tooltip validation for all inputs with class tooltip-validate
        $('input.tooltip-validate').on('focus', function(e) {
            $(this).parents('.form-item').addClass('focus');
            $(this).bind('keyup', validateField);
            
            // Tie the input with it's tooltip
            $(this).attr('aria-describedby', $(this).parents('.form-item').find('.validation-tooltip').attr('id'));
        });
        $('input.tooltip-validate').on('blur', function(e) {
            $(this).parents('.form-item').removeClass('focus');
            $(this).unbind('keyup', validateField);
            
            // Remove the tie because the tooltip has closed
            $(this).removeAttr('aria-describedby');
        });

        //Disable button until Input is filled

        // hide and show all divs - default
        $('body').find(".showhide").on("click", function(e){
            e.preventDefault();
            $(this).find("span").toggle();
            $(this).parent().find(".showhide-content").slideToggle();
            $(this).toggleClass("open");

            if($(this).hasClass("open") && $(this).parent().find(".showhide-content").hasClass("custom-select") || $(this).parent().find(".showhide-content .custom-select").length > 0) {
                $(this).parent().find(".custom-select select").customSelect();
            }

            var currentOpen = $(this).parent().find(".showhide-content");

            // hide and show only selected - accordian
            if($(this).parents().hasClass('sidebar-accordian')){

                $.each($(this).parents('.sidebar-list-content').find('.showhide-content').not(currentOpen), function(){
                    // console.log('current html ' + $(this).html());
                    $(this).slideUp();
                    $(this).parent().find('.showhide').removeClass("open");
                });
            }
        });

        $(target).find(".account-settings-link, .account-close-settings").on("click", function(e){
            e.preventDefault();
            $(this).parents(".account-content-container").toggleClass("settings-open");
        });
        $(target).find(".account-quickmoney-link, .account-close-quickmoney").on("click", function(e){
            e.preventDefault();
            $(this).parents(".account-content-container").toggleClass("quickmoney-open");
        });

        // -------- Form Manipulators --------
        //

        // DatePicker
        $(target).find(".datepicker").datepicker({ maxDate: 0 });

        // Money Field
        $(target).find('.money').autoNumeric('init');

        // Transforms selects beneath items with class "custom-select"
        $(target).find(".custom-select").each(function(e){
            if(!$(this).hasClass("showhide-content") && $(this).parents(".showhide-content").length === 0) {
                $(this).find("select").customSelect();
            }
        });

        /// TODO: Rewrite this to allow other form types than "select" to be form-enablers
        /// TODO: Rewrite jqTransformHidden option to allow multiple form-enablers
        ;

        //
        // -------------------------------------------
        
        // Added show/hide toggling for calendar & list view
        $(target).find('.account-section-filter .cal').on('click', function(e){
            $(this).parents('.account-section.account-section-tabbed').removeClass('list').addClass('cal');
        });
        $(target).find('.account-section-filter .list').on('click', function(e){
            $(this).parents('.account-section.account-section-tabbed').removeClass('cal').addClass('list');
        });

        // toggle between links in the sidebar
        $(target).find('.sidebar-list-option-links a').on('click', function(e){
            e.preventDefault();
            
            var sidebarCont = $(this).parents('.sidebar-list-content');
            var selectedid = $(this).parent('li').index();
            var listtoShow = sidebarCont.find('.sidebar-lists .sidebar-list').eq(selectedid);

            // ACTIVE CLASSES
            // remove active call from all others
            sidebarCont.find('.sidebar-list-option-links a').not($(this)).removeClass('selected');
            // add active class to this
            $(this).addClass('selected');

            
            // HIDE/SHOW CORRESPONDING LISTS
            // hide all but the correct list
            sidebarCont.find('.sidebar-lists .sidebar-list').not(listtoShow).addClass('hide');
            // show corresponding list
            listtoShow.removeClass('hide');
            
        });

        // -------- Modals --------
        //
        $(target).find("a.open-modal").on("click", function(e){
            e.preventDefault();
            $.modal.close();
            $($(this).attr("href")).modal({
                "minWidth":580
            });
        });

    };

    //
    // init
    //
    CITIZENSOLB.init = function() { 
        
        // IE11 in test mode ignores conditional HTML, so we have to manually add the lt-ie8, 9 and 10 tags.
        if(navigator.appVersion.indexOf("MSIE 9.") != -1 && !$("html").hasClass(".lt-ie10")) $("html").addClass("lt-ie10");
        if(navigator.appVersion.indexOf("MSIE 8.") != -1 && !$("html").hasClass(".lt-ie10") && !$("html").hasClass(".lt-ie9")) $("html").addClass("lt-ie10 lt-ie9");
        if(navigator.appVersion.indexOf("MSIE 7.") != -1 && !$("html").hasClass(".lt-ie10") && !$("html").hasClass(".lt-ie9") && !$("html").hasClass(".lt-ie8")) $("html").addClass("lt-ie10 lt-ie9 lt-ie8");

        CITIZENSOLB.initTarget("body");
    };


    // -----------------------------------------
    // DOCUMENT READY
    //
    $(document).ready(function() { CITIZENSOLB.init(); });

}(window.CITIZENSOLB = window.CITIZENSOLB || {}, jQuery));