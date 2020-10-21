<!-- Footer Begin -->
<?php
$fblnk = get_post_meta( 566, 'fblink' )[0];
$lklnk = get_post_meta( 566, 'linkedinlink' )[0];
?>
<footer class="footer">
    <div class="container">
        <div class="row" vertical-gutter="40">
            <div class="col-sm-6 col-lg-3">
                <div class="footer__title">о нас</div>
                <?php
                $foterMenue1=wp_nav_menu(array('menu' => 'footermenue1', 'menu_class' => 'footer__menu', 'echo'=> false));
                $foterMenue1 = str_replace("navigation__link", "footer__link", $foterMenue1);
                echo $foterMenue1;
                ?>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="footer__title">Решения</div>
                <?php
                $foterMenue1=wp_nav_menu(array('menu' => 'footermenue2', 'menu_class' => 'footer__menu', 'echo'=> false));
                $foterMenue1 = str_replace("navigation__link", "footer__link", $foterMenue1);
                echo $foterMenue1;
                ?>
            </div>
            <div class="col-xs-6 col-lg-3">
                <div class="footer__title">пресс-центр</div>
                <?php
                $foterMenue1=wp_nav_menu(array('menu' => 'footermenue3', 'menu_class' => 'footer__menu', 'echo'=> false));
                $foterMenue1 = str_replace("navigation__link", "footer__link", $foterMenue1);
                echo $foterMenue1;
                ?>
                <a href="#" data-target="#modal-1" data-toggle="modal" class="footer__link">Контакт с PR-службой</a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="footer__title">контакты</div>
                <p><a href="tel:+7(727)2620826">+777777777777</a>
                    <br>Алматы</p>
                <ul class="social footer__social">
                    <li class="social__item">
                        <a href="<?=$fblnk?>" class="social__link">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li class="social__item">
                        <a href="<?=$lklnk?>" class="social__link">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                </ul>
                <img src="<?php bloginfo('template_url'); ?>/static/img/general/logo.svg" class="footer__logo" alt="">
                <p>Все права защищены
                    <br>2019 год</p>
            </div>
        </div>
    </div>
</footer>
<!--/. Footer End -->

</div>
<!--/. App Wrapper End -->

</div>
<!--/. App End -->

<!-------------------------------- CONTENT ENDS HERE -------------------------------->

<!-- Modals Begin -->
<noindex>

    <!-- Modal Cta Begin -->
    <div id="modal-1" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#10005;</span>
                </button>
                <form class="form">
                    <h2 class="form__title">Связаться с нами</h2>
                    <div class="control">
                        <input onblur="proverkaPress()" oninput="proverkaPress()" type="text" id="namenodal1" name="name" class="control__input" placeholder="Имя">
                    </div>
                    <div class="control">
                        <input onblur="proverkaPress()" oninput="proverkaPress()" type="text" id="companymodal1" name="company" class="control__input" placeholder="Компания">
                    </div>
                    <div class="control">
                        <input onblur="proverkaPress()" oninput="proverkaPress()" type="text" id="phonemodal1" name="phone" class="control__input" placeholder="+7 (***) ***-**-**">
                    </div>
                    <div class="control">
                        <input onblur="proverkaPress()" oninput="proverkaPress()" type="text" name="email" id="emailmodal1" class="control__input" placeholder="Email">
                    </div>
                    <div class="text-right">
                        <button id="buttonsenddpress" type="button" onclick="getAjaxModal1('1', document.getElementById('namenodal1').value, document.getElementById('companymodal1').value, document.getElementById('phonemodal1').value, document.getElementById('emailmodal1').value)" class="button -bordered form__button" data-target="#modal-3" data-toggle="modal" data-dismiss="modal" disabled>отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function proverkaPress() {
            namePress=nm(document.getElementById('namenodal1').value);
            messPress=nm(document.getElementById('companymodal1').value);
            telPress=ph(document.getElementById('phonemodal1').value);
            emailPress=ff(document.getElementById('emailmodal1').value);
            if(emailPress==1 && telPress==1 && namePress==1 && messPress==1) document.getElementById('buttonsenddpress').disabled = false; else document.getElementById('buttonsenddpress').disabled = true;
        }
        var emailPress=0;
        var telPress=0;
        var namePress=0;
        var messPress=0;

    </script>
    <!--/. Modal Cta End -->

    <!-- Modal Cta Begin -->
    <div id="modal-2" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#10005;</span>
                </button>
                <form class="form">
                    <h2 class="form__title">Связаться с нами</h2>
                    <div class="control">
                        <input type="text" name="name" class="control__input" placeholder="Имя">
                    </div>
                    <div class="control">
                        <input type="text" name="company" class="control__input" placeholder="Компания">
                    </div>
                    <div class="control">
                        <input type="text" name="phone" class="control__input" placeholder="+7 (***) ***-**-**">
                    </div>
                    <div class="control">
                        <input type="text" name="email" class="control__input" placeholder="Email">
                    </div>
                    <div class="control">
                        <textarea class="control__textarea" placeholder="Сообщение"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="button -bordered form__button">отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/. Modal Cta End -->


    <!-- Modal Success Begin -->
    <div id="modal-3" class="modal modal-success fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#10005;</span>
                </button>
                <img src="static/img/general/success.svg" alt="">
                <h2 class="modal__title">Ваша заявка успешно отправлена <br>Спасибо!</h2>
            </div>
        </div>
    </div>
    <!--/. Modal Success End -->

    <!-- Modal Iframe Begin -->
    <div id="iframe-modal" class="modal bm-modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <div class="bm-modal__embed">
                        <iframe class="bm-modal__embed-item jsBmEmbedItem" frameborder="0" src=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/. Modal Iframe End -->

</noindex>
<!--/. Modals End -->
<script src="https://www.google.com/recaptcha/api.js?render=6Lc06soUAAAAALuCAIbbyRYLsHpZar5PI5NMbQOO"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lc06soUAAAAALuCAIbbyRYLsHpZar5PI5NMbQOO', {action: 'homepage'}).then(function(token) {
        });
    });
</script>

<!-- Main scripts. You can replace it, but I recommend you to leave it here -->
<script>
/** Использование патернов для контактных форм**/
    var emailpattern = /^[a-z0-9._-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
    var phonepatern = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;

    function ff(value) {
        var OK = emailpattern.exec(value);
        if (!OK) { return 0; } else { return 1; }
    }

    function ph(value) {
        var OK = phonepatern.exec(value);
        if (!OK) { return 0; }
        else { return 1; }
    }

    function nm(value) {
        if (value != '') return 1; else return 0;
    }
/** конец Использование патернов для контактных форм**/

    function getAjax1(operation, name, phone, solution) {
    grecaptcha.ready(function() {
        // do request for recaptcha token
        // response is promise with passed token
        grecaptcha.execute('6Lc06soUAAAAALuCAIbbyRYLsHpZar5PI5NMbQOO', {action: 'create_comment'}).then(function(token) {
            // add token to form
            $('#comment_form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
            $.post("/ajax.php",{operation: operation, name: name, solution: solution, phone:phone, token: token}, function(result) {
                if(result.success) {
                    console.log(result);
                } else {
                    alert('You are spammer ! Get the @$%K out.');
                }
            });
        });
    });


    $.ajax({
            type:'POST',
            url:'/ajax.php',
            data:{
                'operation':operation,
                'name': name,
                'phone': phone,
                'solution': solution
            },
            success:function(html){
                $('#ajax').html(html);
            },
            error:function(html){
                $('body').css('cursor','default');
                alert('Ошибка подключения!');
            },
        });
    }

    function getAjaxModal1(operation, name, company, phone, email) {
        grecaptcha.ready(function() {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute('6Lc06soUAAAAALuCAIbbyRYLsHpZar5PI5NMbQOO', {action: 'create_comment'}).then(function(token) {
                // add token to form
                $('#comment_form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                $.post("/ajax.php",{operation: operation, name: name, company: company, phone:phone, email: email , token: token}, function(result) {
                    if(result.success) {
                        console.log(result);
                    } else {
                        alert('You are spammer ! Get the @$%K out.');
                    }
                });
            });
        });
    }


    function getAjaxContactForm(operation, name, message, phone, email) {
        grecaptcha.ready(function() {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute('6Lc06soUAAAAALuCAIbbyRYLsHpZar5PI5NMbQOO', {action: 'create_comment'}).then(function(token) {
                // add token to form
                $('#comment_form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                $.post("/ajax.php",{operation: operation, name: name, message: message, phone:phone, email: email , token: token}, function(result) {
                    if(result.success) {
                        console.log(result);
                    } else {
                        alert('You are spammer ! Get the @$%K out.');
                    }
                });
            });
        });
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/static/js/main.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/static/js/separate-js/scripts.js"></script>
<?php wp_footer(); ?>
</body>
</html>
