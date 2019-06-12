// UTM tracking
sbjs.init({
    callback: placeData
});
function placeData(sb) {

    var form = document.querySelectorAll('.contactform'); //get collection of forms with setted class from page

    //put input fields with utm parameter form
    function addUtmField(inputClass, inputValue, form){

        var inputElement = form.getElementsByClassName(inputClass);

        if (inputElement.length == 0) {
            form.insertAdjacentHTML("afterbegin", '<input type="hidden" class="' + inputClass +'" name="' + inputClass + '" value="">');
            inputElement = form.getElementsByClassName(inputClass);
        }
        inputElement[0].value = inputValue;

    }

    (function putInputToForm(){
        form.forEach(function(el){

            //call function every time when we need to put one Utm parameter to the input for each form

            addUtmField('sb_first_src', sb.first.src, el); //first utm_source
            addUtmField('sb_first_mdm', sb.first.mdm, el); //first utm_medium
            addUtmField('sb_first_cmp', sb.first.cmp, el); //first utm_campaign
            addUtmField('sb_first_cnt', sb.first.cnt, el); //first utm_content
            addUtmField('sb_first_trm', sb.first.trm, el); //first utm_term

            addUtmField('sb_current_typ', sb.current.typ, el); //current Type
            addUtmField('sb_current_src', sb.current.src, el); //current utm_source
            addUtmField('sb_current_mdm', sb.current.mdm, el); //current utm_medium
            addUtmField('sb_current_cmp', sb.current.cmp, el); //current utm_campaign
            addUtmField('sb_current_cnt', sb.current.cnt, el); //current utm_content
            addUtmField('sb_current_trm', sb.current.trm, el); //current utm_term

            addUtmField('sb_first_add_fd', sb.first_add.fd, el); //First visit date
            addUtmField('sb_first_add_ep', sb.first_add.ep, el); //First entrance point
            addUtmField('sb_first_add_rf', sb.first_add.rf, el); //First referer

            addUtmField('sb_current_add_fd', sb.current_add.fd, el); //Current visit date
            addUtmField('sb_current_add_ep', sb.current_add.ep, el); //Current entrance point
            addUtmField('sb_current_add_rf', sb.current_add.rf, el); //Current referer

            addUtmField('sb_session_pgs', sb.session.pgs, el); //Pages seen
            addUtmField('sb_session_cpg', sb.session.cpg, el); //Current page

            addUtmField('sb_udata_vst', sb.udata.vst, el); //Visits
            addUtmField('sb_udata_uip', sb.udata.uip, el); //IP
            addUtmField('sb_udata_uag', sb.udata.uag, el); //User agent

            addUtmField('sb_promo_code', sb.promo.code, el); //Promocode

        })
    })()

}

jQuery(document).ready(function () {

    //New form sending and validation
    (function(){
        //validavion phone input
        function phone_validate(phno) {
            var regexPattern=new RegExp(/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/);    // regular expression pattern
            return regexPattern.test(phno);
        }

        //reset all inputs
        function inputReset(form){
            form.find('input').not('input[type="hidden"]').val('');
        }

        //hide modal with form after sending
        function hideModal(){
            var $modal = $('#zvonokzakaz'),
                $body = $('body');
            if ($modal){
                $modal.hide(400);
                $body.removeClass('modal-open');
                $modal.find('.success-msg').remove();
            }
        }


        var $errorTemp = '<div class="err-msg">Введите корректный номер телефона</div>';

        var $successTmp = '<div class="success-msg"><p>Спасибо за заявку</p><button class="one-more btn btn-danger">Отправить еще</button></div>';

        //send form
        $('button[type=submit]').click(function (e) {
            e.preventDefault();
            var $btn = $(this),
                $form = $btn.closest('form'),
                $errMsg = $form.find('.err-msg'),
                $phoneInput = $form.find('input[name="phone"]'),
                $phoneData = $phoneInput.val();

            if ( phone_validate($phoneData) ) {
                console.log('OK');
                $btn.button('loading');
                jQuery.ajax({
                    url: "../mail/mail.php",
                    type: "POST",
                    dataType: "html",
                    data: $form.serialize(),
                    success: function (data) {
                        if (data > 0) {
                            console.log('Форма отправлена');
                            // yaCounter********.reachGoal('target');
                            // ga('send', 'event', 'Forms', 'Send');
                        }
                        $form.find('input.req').removeClass('red');
                        $btn.button('reset');

                        if ($errMsg){$errMsg.remove()};
                        $form.prepend($successTmp);

                        inputReset($form);
                        console.log(data);

                        if($errMsg) {$errMsg.remove()};

                        setTimeout(hideModal, 4000);

                        var $moreBtn = $form.find('.one-more'),
                            $moreWrapper = $form.find('.success-msg');

                        $moreBtn.click(function(){
                            $moreWrapper.remove();
                        })

                    }
                });

            } else {

                console.log('Not valid');
                if($errMsg) {$errMsg.remove()};
                //обходим все input
                $form.find('input.req').each(function () {
                    if ($(this).val() == '') {
                        jQuery(this).addClass('red');
                        $phoneInput.after($errorTemp);
                    }
                });
            }

        });
    })()




});