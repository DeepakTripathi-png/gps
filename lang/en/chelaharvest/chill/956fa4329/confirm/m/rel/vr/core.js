function areCookiesEnabled() {
    return navigator.cookieEnabled;
}

function addClientStyleErrorMessage(errorMessage, id) {
	var elementId = '#' + id;
	var element = $j(element);
    if ($j(elementId).length == 0) {
        return;
    }
    var errorId = id + '-help-block';
    $j(elementId).addClass('has-error').attr('aria-describedby', errorId);
   
    var spanElement = $('<span />').attr('id', errorId).attr('role','alert').addClass('error help-block').html(errorMessage);
    spanElement.insertAfter(element);
}

jQuery.fn.preventDoubleSubmission = function() {
    $j(this).submit(function(e) {
        var $form = $j(this);
        if ($form.data('submitted') === true) {
            //Previously submitted - don't submit again
            e.preventDefault();
        } else {
            disableBut($form.find(":submit"));
            $form.data('submitted', true);
        }
    });
};

function disableBut(button) {
    button.addClass('disabledBtn');
    button.prop('disabled',true);
}

var Core = (function($j) {
    var registerVZTPageTagClick = function(selector, tagAction) {
        $j(selector).click(function() {
            scLinkTrackID(tagAction);
        });
    };

    return {
        registerVZTPageTagClick: registerVZTPageTagClick
    };
})(jQuery);

(function($j) {
    var methods = {
        required: function($input, param) {
            var val = $input.val();
            //console.log("required: " + val);
            return val && val.length > 0;
        },
        minLength: function($input, param) {
            var val = $input.val();
            //console.log("minLength: " + val);
            return val && val.length >= param;
        },
        maxLength: function($input, param) {
            var val = $input.val();
            //console.log("maxLength: " + val);
            return val && val.length <= param;
        },
        digits: function($input, param) {
            var val = $input.val();
            //console.log("digits: " + val);
            return val && /^\d+$/.test(val)
        },
        notDigits: function($input, param) {
            var val = $input.val();
            //console.log("digits: " + val);
            return val && !/^\d+$/.test(val)
        },
        rangeLength: function($input, params) {
            var val = $input.val();
            //console.log("rangeLength: " + val);
            return val && val.length >= params[0] && val.length <= params[1];
        },
        match: function($input, param) {
            var val = $input.val();
            //console.log("match: " + val + ", regex: " + param);
            return val && new RegExp(param).test(val);
        }
    };

    $j.fn.flyout = function(overrideOptions) {
        var id = this.attr('id');
        var containerID = id + '-flyout';

        var options = {
            id: id,
            containerID: containerID,
            validFieldClass: 'valid-field',
            invalidFieldClass: 'invalid-field',
            hideOnStart: false
        };
        $j.extend(options, overrideOptions);
        options.results = {
            attempts: 0,
            totalRules: options.rules.length,
            totalSuccess: 0,
            totalFailed: 0
        };

        renderFlyout(options);

        var $input = $j('#' + id);

        $input.one('focus', function() {
            if (options.hideOnStart) {
                $j('#' + containerID).removeClass('hidden');
            }

            if (options.onStart) {
                options.onStart.call(this);
            }
        });

        // cut/paste events?
        $input.on('keyup blur', function() {
            //console.log("keyup or blur");
            $("li").addClass(options.validFieldClass);
            executeRules($input, options);
        });

        $input.on('focus', function() {
            // If the flyout is hidden when input field is refocused, show the flyout
            if ($j('#' + containerID + '.hidden').length != 0) {
                $j('#' + containerID).removeClass('hidden');
            }
        });
        
        $input.on('focusout', function() {
            // when focus out on an input field, and all rules are valid, hide the flyout
            if (options.results.totalRules == options.results.totalSuccess) {
                $j('#' + containerID).addClass('hidden');
            }
        });
    };

    function renderFlyout(options) {
        var id = options.id;
        var $input = $j('#' + id);
        var $div = $j('#' + options.containerID);
        var divFound = $div.length;
        if (!divFound) {
            //console.log("div element not found");
            $div = $j('<div />');
            $div.attr('id', options.containerID);
        }
        $div.addClass('flyout');
        if (options.hideOnStart) {
            $div.addClass('hidden');
        }

        var $p = $j('<p />');
        $p.text(options.title);
        $p.appendTo($div);

        var $ul = $j('<ul />');
        var $span;
        var $li;
        var suffix;
        $j.each(options.rules, function(index, rule) {
            $span = $j('<span />');
            $span.text(rule.text);

            $li = $j('<li />');
            if (rule.hidden) {
                $li.addClass('hidden');
            }
            suffix = (rule.idSuffix) ? rule.idSuffix : rule.name;
            $li.attr('id', id + '-' + suffix);
            $span.appendTo($li);
            $li.appendTo($ul);
        });
        if (options.extraInfo) {
            $j.each(options.extraInfo, function(index, text) {
                $span = $j('<span />');
                $span.text(text);
                $li = $j('<li />');
                $span.appendTo($li);
                $li.appendTo($ul);
            });
        }
        $ul.appendTo($div);
        if (!divFound) {
            $input.after($div);
        }
    }

    function executeRules($input, options) {
        var val = $input.val();
        if (!val) {
            //console.log("empty value, skipping rules...");
            return;
        }

        options.results.attempts++;
        options.results.totalSuccess = 0;
        options.results.totalFailed = 0;
        options.results.successRules = [];
        options.results.failedRules = [];
        $j.each(options.rules, function(index, rule) {
            var callback = rule.callback;
            var param = rule.param;
            var suffix;
            var result;
            if (callback) {
                suffix = rule.idSuffix;
                result = rule.callback.call(this, $input, param);
            } else {
                var methodName = rule.name;
                suffix = (rule.idSuffix) ? rule.idSuffix : methodName;
                result = methods[methodName].call(this, $input, param);
            }

            if (result) {
                options.results.totalSuccess++;
                options.results.successRules.push(suffix);
            } else {
                options.results.totalFailed++;
                options.results.failedRules.push(suffix);
            }
            var displayID = '#' + options.id + '-' + suffix;
            //console.log('rule: ' + methodName + ', param: ' + param + ', displayID: ' + displayID);
            var $displayElement = $j(displayID);

            if (result) {
                $displayElement.addClass(options.validFieldClass);
                $displayElement.removeClass(options.invalidFieldClass);
            } else {
                $displayElement.addClass(options.invalidFieldClass);
                $displayElement.removeClass(options.validFieldClass);
            }
        });
        //console.log(options.results);
        if (options.onSuccess && options.results.totalRules == options.results.totalSuccess) {
            options.onSuccess.call(this, options.results);
        } else if (options.onFailure) {
            options.onFailure.call(this, options.results);
        }
    }

    $j.fn.progressBar = function(overrideOptions) {
        var containerID = this.attr('id');
        var options = {
            containerID: containerID,
            hideOnStart: false,
            headerLeft: '',
            headerRight: '',
            value: 0
        };
        $j.extend(options, overrideOptions);

        renderProgressBar(options);

        return {
            containerID: options.containerID,
            update: function(percentage, colorClass) {
                var selector = '#' + this.containerID;
                updateProgressBar(selector, percentage, colorClass);
            },
            updateHeaderRight: function(text) {
                var selector = '#' + this.containerID;
                var header = $j(selector + ' .progress-label-right').text(text);
            }
        };
    };

    function updateProgressBar(selector, percentage, colorClass) {
        var $progressBar = $j(selector + ' .progress-bar');
        var success = (percentage == 100);
        $progressBar.removeClass('progress-bar-success progress-bar-warning progress-bar-danger');
        $progressBar.addClass(colorClass);
        $progressBar.attr('aria-valuenow', percentage);
        $progressBar.attr('style', 'width: ' + percentage + '%;');
        $j(selector + ' .progress-bar span').text(percentage + '% complete');
    }

    function renderProgressBar(options) {
        var containerSelector = '#' + options.containerID;
        var $div = $j(containerSelector);
        $div.addClass('progress-bar-container');
        if (options.hideOnStart) {
            $div.addClass('hidden');
        }

        if (options.headerLeft || options.headerRight) {
            var $labelDiv = $j('<div />');
            addHeader(options.headerLeft, 'progress-label-left', $labelDiv);
            addHeader(options.headerRight, 'progress-label-right text-right', $labelDiv);
            $labelDiv.appendTo($div);
        }
        var $progressDiv = $j('<div />');
        $progressDiv.addClass('progress');

        var $progressBarDiv = $j('<div />');
        $progressBarDiv.addClass('progress-bar');
        $progressBarDiv.attr('role', 'progressbar');
        $progressBarDiv.attr('aria-valuemin', 0);
        $progressBarDiv.attr('aria-valuemax', 100);

        var $srOnly = $j('<span />');
        $srOnly.addClass('sr-only');
        $srOnly.appendTo($progressBarDiv);

        $progressBarDiv.appendTo($progressDiv);
        $progressDiv.appendTo($div);

        updateProgressBar(containerSelector, options.value);
    }

    function addHeader(text, className, parent) {
        var $span = $j('<span />');
        $span.addClass(className);
        $span.text(text);
        $span.appendTo(parent);
    }

    $j.fn.formValidate = function(overrideOptions) {
        var selector = this.attr('id');
        var options = {
        		onfocusout: false,
        		errorElement: 'span',
            errorPlacement: function (error, element) {
                var id = element.attr('name');
                var errorId = id + '-help-block';
                var $divErrorContainer= $j('#' + id + '-error-container');
                var divErrorContainerFound = $divErrorContainer.length;
                error.attr('id', errorId);
                error.addClass('help-block');
                error.attr('role','alert');

                var inputType = element.prop('type');
                if (divErrorContainerFound) {
                    error.appendTo($divErrorContainer);
                } else if (inputType == 'checkbox' || inputType == 'radio') {
                    error.insertAfter(element.parent( "label" ));
                } else {
                    error.insertAfter(element);
                }

                element.attr('aria-describedby', errorId);
            },
            highlight: function (element, errorClass, validClass) {
                var $input = $j(element);
                var inputType = $input.attr('type');
                if (inputType == 'checkbox' || inputType == 'radio') {
                    $j('input[type=' + inputType + '][name=' + element.name + ']').each(function (i, sameName) {
                        $j(sameName).parents('.' + inputType).addClass('has-error'); 
                    });
                } else {
                    $j(element).parents('.form-group').addClass('has-error'); 
                    $j(element).addClass('has-error'); 			  
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                var $input = $j(element);
                var inputType = $input.attr('type');
                if (inputType == 'checkbox' || inputType == 'radio') {
                    $j('input[type=' + inputType + '][name=' + element.name + ']').each(function (i, sameName) {
                        $j(sameName).parents('.' + inputType).removeClass('has-error'); 
                    });
                } else {
                    $j(element).parents('.form-group').removeClass('has-error'); 
                    $j(element).removeClass('has-error');					
                }
            },
            submitHandler: function(form){
                if (options.buttonID) {
                    $j(options.buttonID).attr('disabled', 'disabled');
                    form.submit();
                }
            }
        };
        $j.extend(options, overrideOptions);
        $j('#' + selector).validate(options);

        // custom validation rules
        $j.validator.addMethod('alphanumericspace', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /^[a-zA-Z0-9 ]+$/);
        }, 'Must be Alphanumeric or space');
        $j.validator.addMethod('oneletter', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /[a-zA-Z]+/);
        }, 'Must contain at least one letter');
        $j.validator.addMethod('onenumber', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /[0-9]+/);
        }, 'Must contain at least one number');
        $j.validator.addMethod('ascii', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /^[\x21-\x7E]+$/);
        }, 'ASCII Characters only');
        $j.validator.addMethod('usernamechars', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /^[\w\-.@\'\s\+]+$/);
        }, 'Alphanumeric, dash, period, at sign, space, and plus allowed');
        $j.validator.addMethod('nodigitsonly', function(value, element) {
            return !$j.validator.methods.pattern.call(this, value, element, /^[\d]+$/);
        }, 'Must not be digits only');
        $j.validator.addMethod('noleadingspace', function(value, element) {
            return !$j.validator.methods.pattern.call(this, value, element, /^\s+/);
        });
        $j.validator.addMethod('notrailingspace', function(value, element) {
            return !$j.validator.methods.pattern.call(this, value, element, /\s+$/);
        });
        $j.validator.addMethod('secretanswerchars', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /^[\w.\s]*$/);
        });
        $j.validator.addMethod('emailAddress', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /^[a-zA-Z0-9](\.?\_?\-?[a-zA-Z0-9]){0,}@[a-zA-Z0-9-_]+\.([a-zA-Z0-9-_]{1,}\.){0,}[a-zA-Z]{2,}$/);
        });
        $j.validator.addMethod('emailAddressOrMobileNumber', function(value, element) {
            return ($j.validator.methods.pattern.call(this, value, element, /^[a-zA-Z0-9](\.?\_?\-?[a-zA-Z0-9]){0,}@[a-zA-Z0-9-_]+\.([a-zA-Z0-9-_]{1,}\.){0,}[a-zA-Z]{2,}$/)
            || $j.validator.methods.pattern.call(this, value, element, /^\d{10}$/));
        });
        $j.validator.addMethod('mobileNumberFormat', function(value, element) {
            return $j.validator.methods.pattern.call(this, value, element, /^\d{3}.\d{3}.\d{4}$/);
        });
        // This is not perfect, will revisit in next release.
        $j.validator.addMethod("notEqual", function(value, element, param) {
            return (value == "" && $j(param).val() == "") || (value!= "" && value != $j(param).val());
        });
    };
}(jQuery));

var Rule = (function() {
    var equalTo = function(equalToID) {
        return {
            required: true,
            equalTo: equalToID
        }
    }
    var optionalEqualTo = function(equalToID) {
        return {
            required: ($j(equalToID).val() != '' && $j(equalToID).val.length > 0) ,
            equalTo: equalToID
        }
    }
    var notEqualTo = function(equalToID) {
        return {
            required: ($j(equalToID).val() != '' && $j(equalToID).val.length > 0) ,
            notEqual: equalToID
        }
    }

    return {
        zipCode: {
           required: true,
           digits: true,
           minlength: 5,
           maxlength: 5
        },
        last4SSN: {
            required: true,
            minlength: 4,
            maxlength: 4,
            digits: true
        },
        billingSystemPassword: {
            required: true,
            alphanumericspace: true
        },
        currentPassword: notEqualTo,
        password: {
            required: true,
            minlength: 8,
            maxlength: 20,
            oneletter: true,
            onenumber: true,
            ascii: true,
            nowhitespace: true,
            blacklist: true
        },
        optionalPassword: {
            minlength: 8,
            maxlength: 20,
            oneletter: true,
            onenumber: true,
            ascii: true,
            nowhitespace: true,
            blacklist: true
        },
        confirmPassword: equalTo,
        optionalConfirmPassword: optionalEqualTo,
        accountSecurityCode: {
            required: true,
            minlength: 4,
            maxlength: 4,
            digits: true
        },
        userName: {
            required: true,
            minlength: 6,
            maxlength: 60,
            usernamechars: true,
            nowhitespace: true,
            nodigitsonly: true
        },
        termsAndConditions: {
            required: true
        },
        greetingName: {
            required: true,
            minlength: 1,
            maxlength: 10
        },
        name: {
            required: true,
            minlength: 1,
            maxlength: 10
        },
        firstName: {
        	required: true,
            minlength: 1,
            maxlength: 30
        },
        lastName: {
        	required: true,
            minlength: 1,
            maxlength: 30
        },
        emailAddress: {
            required: true,
            emailAddress: true
        },
        confirmEmailAddress: equalTo,
        secretAnswer: {
            required: true,
            minlength: 3,
            maxlength: 40,
            noleadingspace: true,
            notrailingspace: true,
            secretanswerchars: true
        },
        challengeQuestion: {
            required: true,                       
            min: 1,
            number: true
        },
        challengeAnswer: {
            required: true,
            minlength: 3,
            maxlength: 40,
            noleadingspace: true,
            notrailingspace: true,
            secretanswerchars: true
        },
        optionalChallengeQuestion: {
            min: 1,
            number: true
        },
        optionalChallengeAnswer: {
            minlength: 3,
            maxlength: 40,
            secretanswerchars: true
        },
        securityPIN: {
            required: true,
            minlength: 6,
            maxlength: 6,
            digits: true
        },
        userNameOrMobileNumber: {
            required: true,
            minlength: 6,
            maxlength: 60,
            usernamechars: true,
            nowhitespace: true
        },
        optionalMobileNumber: {
            minlength: 10,
            maxlength: 10,
            digits: true,
        },
        mobileNumber: {
            required: true,
            minlength: 10,
            maxlength: 10,
            digits: true,
        },
        mobileNumberFormatted: {
            required: true,
            minlength: 12,
            maxlength: 12,
            mobileNumberFormat : true,
        },
        emailAddressOrMobileNumber: {
            required: true,
            emailAddressOrMobileNumber: true,
        }
    };
})();

var Message = (function() {
    return {
        zipCode: 'Please enter your Billing ZIP Code',
        last4SSN: 'Please enter your last 4 digits of Social Security Number (Or Fed Tax ID)',
        billingSystemPassword: 'Please enter your Billing System Password',
        password: 'Please enter a valid password',
        confirmPassword: 'The passwords do not match',
        currentPassword: 'The current password you entered is incorrect. Current password and new password cannot be same',
        termsAndConditions: 'You must accept the terms and conditions to continue',
        userName: 'Please enter a valid User ID',
        secretQuestion: 'Please select a secret question',
        secretAnswer: 'Please enter a valid secret answer',
        emailAddress: 'Please enter a valid email address',
        confirmEmailAddress: 'The email addresses do not match',
        greetingName: 'Please enter a valid greeting name',
        securityPIN: 'Please enter a valid PIN',
        userNameOrMobileNumber: 'Please enter a valid Mobile Number or User ID',
        mobileNumber: 'Please enter a valid Mobile Number',
        emailAddressOrMobileNumber: 'Please enter a valid Email Address or Mobile Number',
        name: 'Please enter a valid Name',
        firstName: 'Please enter a valid first name',
        lastName: 'Please enter a valid last name'
    };
})();
var blackListFailed = '';
var Validation = (function($j) {
    var passwordFlyoutAndProgressBar = function(overrideOptions) {
        var options = {
            inputID: '#userName',
            progressBarHeaderLeft: 'Strength',
            progressBarHeaderRight: '',
            flyoutTitle: 'Your input field needs to meet the following criteria:',
            hideOnStart: true
        };
        $j.extend(options, overrideOptions);
        options.progressBarID = options.inputID + '-progress-bar';
        //console.log(options);

        var $progressBar = $j(options.progressBarID).progressBar({
            headerLeft: options.progressBarHeaderLeft,
            headerRight: options.progressBarHeaderRight,
            hideOnStart: options.hideOnStart
        });

        var blackList = Blacklist.init({
            encodedExactMatch: options.encodedExactMatch,
            encodedSubstringMatch: options.encodedSubstringMatch
        });

        $j(options.inputID).flyout({
            title: options.flyoutTitle,
            hideOnStart: options.hideOnStart,
            rules: [{
                name: 'rangeLength',
                text: '8-20 characters',
                param: [8, 20]
            }, {
                name: 'match',
                idSuffix: 'matchOneLetter',
                text: '1 letter',
                param: '[a-zA-Z]+'
            }, {
                name: 'match',
                idSuffix: 'matchOneDigit',
                text: '1 number',
                param: '[0-9]+'
            }, {
                text: 'Not easy to guess',
                idSuffix: 'blacklist',
                callback: function ($input, param) {
                    var val = $input.val();
                    //console.log("match: " + val + ", regex: " + param);
                    return !blackList.match(val);
                }
            }, {
                name: 'match',
                idSuffix: 'matchOneSpecialChar',
                text: '1 special character',
                param: '[^A-Za-z0-9]',
                hidden: true
            }],
            onStart: function() {
                $j(options.progressBarID).removeClass('hidden');
            },
            onSuccess: function(results) {
                $progressBar.update(100, 'progress-bar-success');
                $progressBar.updateHeaderRight('Strong');
            },
            onFailure: function(results) {
                var percentage = parseInt((results.totalSuccess/ results.totalRules) * 100);
                blackListFailed = inArray('blacklist', results.failedRules);
                var basicRulesFailed = inArray('rangeLength', results.failedRules) || inArray('matchOneDigit', results.failedRules) || inArray('matchOneLetter', results.failedRules);
                var headerRight = blackListFailed || basicRulesFailed ? 'Not valid' : 'Medium';
                var colorClass = headerRight == 'Not valid' ? 'progress-bar-danger' : 'progress-bar-warning';
                $progressBar.update(percentage, colorClass);
                $progressBar.updateHeaderRight(headerRight);
            }
        });
    };
    //Added for 5G
    var passwordFlyoutAndProgressBarNew = function(overrideOptions) {
        var options = {
            inputID: '#userName',
            progressBarHeaderLeft: 'Strength',
            progressBarHeaderRight: '',
            flyoutTitle: 'Password',
            hideOnStart: true
        };
        $j.extend(options, overrideOptions);
        options.progressBarID = options.inputID + '-progress-bar';
        console.log(options);

        var $progressBar = $j(options.progressBarID).progressBar({
            headerLeft: options.progressBarHeaderLeft,
            headerRight: options.progressBarHeaderRight,
            hideOnStart: options.hideOnStart
        });

        var blackList = Blacklist.init({
            encodedExactMatch: options.encodedExactMatch,
            encodedSubstringMatch: options.encodedSubstringMatch
        });
		console.log("test");
        $j(options.inputID).flyout({
            title: options.flyoutTitle,
            hideOnStart: options.hideOnStart,
            rules: [{
                name: 'match',
                idSuffix: 'matchOneLetter',
                text: 'Contains at least 1 letter',
                param: '[a-zA-Z]+'
            }, {
                name: 'match',
                idSuffix: 'matchOneDigit',
                text: 'Contains at least 1 number',
                param: '[0-9]+'
            }, {
                name: 'rangeLength',
                text: 'Is between 8-20 characters',
                param: [8, 20]
            },{
                text: 'Is not easy to guess',
                idSuffix: 'blacklist',
                callback: function ($input, param) {
                    var val = $input.val();
                    //console.log("match: " + val + ", regex: " + param);
                    return !blackList.match(val);
                }
            }, {
                name: 'match',
                idSuffix: 'matchOneSpecialChar',
                text: '1 special character',
                param: '[^A-Za-z0-9]',
                hidden: true
            }],
            onStart: function() {
                $j(options.progressBarID).removeClass('hidden');
            },
            onSuccess: function(results) {
			//console.log("results : "+results);
                $progressBar.update(100, 'progress-bar-success');
                $progressBar.updateHeaderRight('Strong');
				//$('#btn_createpwd').prop("disabled", false);
            },
            onFailure: function(results) {
                var percentage = parseInt((results.totalSuccess/ results.totalRules) * 100);
                blackListFailed = inArray('blacklist', results.failedRules);
                var basicRulesFailed = inArray('rangeLength', results.failedRules) || inArray('matchOneDigit', results.failedRules) || inArray('matchOneLetter', results.failedRules) || inArray('blacklist', results.failedRules);
                var headerRight = blackListFailed || basicRulesFailed ? 'Not valid' : 'Medium';
                var colorClass = headerRight == 'Not valid' ? 'progress-bar-danger' : 'progress-bar-warning';
				$progressBar.update(percentage, colorClass);
                $progressBar.updateHeaderRight(headerRight);
            }
        });
    };
    
    //Added for common domain
    var passwordFlyoutAndProgressBarCD = function(overrideOptions) {
        var options = {
            inputID: '#userName',
            progressBarHeaderLeft: 'Strength',
            progressBarHeaderRight: '',
            flyoutTitle: 'Your new password must be:',
            hideOnStart: true
        };
        $j.extend(options, overrideOptions);
        options.progressBarID = options.inputID + '-progress-bar';
        //console.log(options);

        var $progressBar = $j(options.progressBarID).progressBar({
            headerLeft: options.progressBarHeaderLeft,
            headerRight: options.progressBarHeaderRight,
            hideOnStart: options.hideOnStart
        });

        var blackList = Blacklist.init({
            encodedExactMatch: options.encodedExactMatch,
            encodedSubstringMatch: options.encodedSubstringMatch
        });

        $j(options.inputID).flyout({
            title: options.flyoutTitle,
            hideOnStart: options.hideOnStart,
            rules: [{
                name: 'rangeLength',
                text: '8-20 characters long',
                param: [8, 20]
            }, {
                name: 'match',
                idSuffix: 'matchOneLetter',
                text: 'At least 1 letter',
                param: '[a-zA-Z]+'
            }, {
                name: 'match',
                idSuffix: 'matchOneDigit',
                text: 'At least 1 number',
                param: '[0-9]+'
            }, {
                text: 'Hard to guess',
                idSuffix: 'blacklist',
                callback: function ($input, param) {
                    var val = $input.val();
                    //console.log("match: " + val + ", regex: " + param);
                    return !blackList.match(val);
                }
            }, {
                name: 'match',
                idSuffix: 'matchOneSpecialChar',
                text: '1 special character',
                param: '[^A-Za-z0-9]',
                hidden: true
            }],
            onStart: function() {
                $j(options.progressBarID).removeClass('hidden');
            },
            onSuccess: function(results) {
                $progressBar.update(100, 'progress-bar-success');
                $progressBar.updateHeaderRight('Strong');
            },
            onFailure: function(results) {
                var percentage = parseInt((results.totalSuccess/ results.totalRules) * 100);
                blackListFailed = inArray('blacklist', results.failedRules);
                var basicRulesFailed = inArray('rangeLength', results.failedRules) || inArray('matchOneDigit', results.failedRules) || inArray('matchOneLetter', results.failedRules);
                var headerRight = blackListFailed || basicRulesFailed ? 'Not valid' : 'Medium';
                var colorClass = headerRight == 'Not valid' ? 'progress-bar-danger' : 'progress-bar-warning';
                $progressBar.update(percentage, colorClass);
                $progressBar.updateHeaderRight(headerRight);
            }
        });
    };

    var userNameFlyout = function(overrideOptions) {
        var options = {
            inputID: '#userName',
            title: 'User ID Rules:',
            hideOnStart: true
        };
        $j.extend(options, overrideOptions);

        $j(options.inputID).flyout({
            title: options.title,
            hideOnStart: options.hideOnStart,
            rules: [{
                name: 'rangeLength',
                text: '6-60 characters',
                param: [6, 60]
            }, {
                name: 'match',
                idSuffix: 'validChars',
                text: 'Characters Allowed: \"At\" Sign (@), Underscore (_), Hyphen (-), Apostrophe (\'), Plus (+) and Period (.)',
                param: /^[a-zA-Z0-9@_\-\'\+\.]+$/
            }, {
                name: 'match',
                idSuffix: 'noSpace',
                text: 'No Spaces',
                param: /^\S+$/
            }, {
                name: 'notDigits',
                text: 'Cannot Be All Numbers'
            }]
        });
    };
    var userNameFlyoutNew = function(overrideOptions) {
        var options = {
            inputID: '#userName',
            title: 'User ID Requirements:',
            hideOnStart: true
        };
        $j.extend(options, overrideOptions);

        $j(options.inputID).flyout({
            title: options.title,
            hideOnStart: options.hideOnStart,
            rules: [{
                name: 'rangeLength',
                text: '6-60 characters',
                param: [6, 60]
            }, {
                name: 'match',
                idSuffix: 'validChars',
                text: 'Characters allowed: \"At\" sign (@), Underscore (_), Hyphen (-), Plus (+) and Period (.)',
                param: /^[a-zA-Z0-9@_\-\'\+\.]+$/
            }, {
                name: 'match',
                idSuffix: 'noSpace',
                text: 'No spaces',
                param: /^\S+$/
            }, {
                name: 'notDigits',
                text: 'Cannot be all numbers'
            }]
        });
    };

    var challengeAnswerFlyout = function(overrideOptions) {
        var options = {
            inputID: '#secretAnswer',
            title: 'Secret Answer Rules:',
            hideOnStart: true
        };
        $j.extend(options, overrideOptions);

        $j(options.inputID).flyout({
            title: options.title,
            hideOnStart: options.hideOnStart,
            rules: [{
                name: 'rangeLength',
                text: '3-40 characters',
                param: [3, 40]
            }, {
                name: 'match',
                idSuffix: 'validChars',
                text: 'Allow letters, numbers, space ( ), and period (.)',
                param: /[a-zA-Z0-9]+/
            }, {
                name: 'match',
                idSuffix: 'noLeadingOrTralingSpaces',
                text: 'No leading or trailing spaces',
                param: /^[^\s]+.*[^\s]+$/
            }],
            extraInfo: ["Not case sensitive"]
        });
    };

    function inArray(value, array) {
        return $j.inArray(value, array) > -1;
    }

    return {
        passwordFlyoutAndProgressBar: passwordFlyoutAndProgressBar,
        passwordFlyoutAndProgressBarNew: passwordFlyoutAndProgressBarNew,
        passwordFlyoutAndProgressBarCD: passwordFlyoutAndProgressBarCD,
        userNameFlyout: userNameFlyout,
        userNameFlyoutNew: userNameFlyoutNew,
        challengeAnswerFlyout: challengeAnswerFlyout
    };
})(jQuery);