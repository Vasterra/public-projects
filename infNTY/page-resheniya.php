<?php get_header(); ?>
<!-- App Main Begin -->
<main role="main" class="app__main">

    <!-- Page Begin -->
    <div class="page">

        <!-- Page Header Begin -->
        <div class="page__header" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/header-bg.jpg')">
            <div class="container">
                <div class="page__header-title typed-effect">
                    <div id="js-typed-strings">
                        <p>Решения</p>
                    </div>
                </div>
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">Главная</a>
                    </li>
                    <li class="breadcrumbs__item">
                        Решения
                    </li>
                </ul>
            </div>
        </div>
        <!--/. Page Header End -->
                    <?php
                    $post_588 = get_post( 588 );
                    $PTitle588 = $post_588->post_title;
                    $PContent588=apply_filters( 'the_content', $post_588->post_content );
?>
        <div class="page__content">
			<div class="container">
				<div class="page__topbar">
					<button type="button" class="button -bordered ml-auto" data-target="#modal-1" data-toggle="modal">связаться с нами</button>
				</div>
				<?=$PContent588 ?>
				<div class="solution-c">
					<div class="solution-c__item">
						<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-1.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Омниканальность</div>
						<div class="solution-c__text">Доступность продуктов и услуг через различные устройства и интерфейсы с обеспечения бесшовной и непрерывной коммуникации с клиентом</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-1.jpg" class="solution-c__background" alt="">
					</div>
					<div class="solution-c__item">
							<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-2.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Обслуживание всех типов клиентов</div>
						<div class="solution-c__text">Единый интерфейс для малого и среднего бизнеса, корпораций, индивидуальных предпринимателей и частных клиентов</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-2.jpg" class="solution-c__background" alt="">					
					</div>
					<div class="solution-c__item">
							<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-3.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Интегрированный контент менеджмент</div>
						<div class="solution-c__text">Встроенные инструменты для управления содержимым без привлечения разработчиков</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-3.jpg" class="solution-c__background" alt="">				
					</div>
					<div class="solution-c__item">
					<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-4.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Управление опытом клиента</div>
						<div class="solution-c__text">Понимание профиля и основных потребностей клиента позволяет увеличить силу бренда и повысить уровень его лояльности</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-4.jpg" class="solution-c__background" alt="">
					</div>
					<div class="solution-c__item">
					<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-5.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Удобный интерфейс</div>
						<div class="solution-c__text">Удобный, отвечающий всем современным трендам, интерфейс с возможностью кастомизации «под себя»</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-5.jpg" class="solution-c__background" alt="">
					</div>
					<div class="solution-c__item">
						<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-6.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Гибкость и совместимость</div>
						<div class="solution-c__text">Комфортная и безотказная работа платформы на любом программном и аппаратном обеспечении</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-6.jpg" class="solution-c__background" alt="">
					</div>
					<div class="solution-c__item">
					<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-7.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Модульная архитектура</div>
						<div class="solution-c__text">Возможность по-модульного вывода на рынок инновационных продуктов, услуг и сервисов позволит обеспечить эффективный TimeToMarket</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-7.jpg" class="solution-c__background" alt="">
					</div>
					<div class="solution-c__item">
					<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-8.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Технологичность</div>
						<div class="solution-c__text">Использование современных технологий и лучших мировых практик обеспечивает высокую скорость работы при незначительной нагрузке на оборудование.</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-8.jpg" class="solution-c__background" alt="">
					</div>
					<div class="solution-c__item">
					<img src="<?php bloginfo('template_url'); ?>/static/img/content/icon-9.svg" class="solution-c__icon" alt="">
						<div class="solution-c__title">Масштабируемость и отказоустойчивость</div>
						<div class="solution-c__text">Стабильная работа платформы при увеличении нагрузки и росте количества клиентов</div>
						<img src="<?php bloginfo('template_url'); ?>/static/img/general/features-9.jpg" class="solution-c__background" alt="">
					</div>
				</div>

            <div class="cta -sm mt-5">
                <div class="cta__card" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/info-bg.jpg')">
                    <img src="<?php bloginfo('template_url'); ?>/static/img/general/ic-cta.svg" alt="">
                    <div class="cta__title">Что входит в платформу Digital Bank?</div>
                </div>
            </div>
			</div>
		</div>
        <!-- Page Content Begin -->
        <div class="page__content">
            <div class="container">
                <div class="solution-b">


                    <?php
                    $query = new WP_Query(
                        array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'cat' => [23],
                            'orderby' => 'date',
                            'order' => 'DESC',
                        )
                    );
                    $i=0;
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            if ($i>0) { $st=" order-md-last"; $i=0; } else { $st=""; $i=1; }
                            $pic = get_post_meta( get_the_ID(), 'new' );
                            $ankor = get_post_meta( get_the_ID(), 'ankor' )[0];
                            if ($pic[0]!='') $pcic=$pic[0]; else $pcic="";
                            ?>
                            <div class="solution-b__item">
                                <div class="row align-items-center">
                                    <div class="col-md-6 text-center<?=$st?>">
                                        <a name="<?=$ankor?>"><img src="<?=$pcic ?>" alt=""></a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="solution-b__title"><?php the_title(); ?></div>
                                        <div class="solution-b__text">
                                            <?=the_excerpt_max_charlength(500)?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }}  ?>
                </div>
                        <form class="form contacts__form mb-5">
                            <h2 class="form__title">Заказать презентацию</h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="control">
                                        <input type="text" id="resheniyaname" onblur="proverkaResheniya()" oninput="proverkaResheniya()"  name="name" class="control__input" placeholder="Имя">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="control">
                                        <input type="text" id="resheniyaphone"  onblur="proverkaResheniya()" oninput="proverkaResheniya()" name="phone" class="control__input" placeholder="+7 (***) ***-**-**">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="control">
                                        <input type="text" id="resheniyaemail"  onblur="proverkaResheniya()" oninput="proverkaResheniya()"  name="email" class="control__input" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="control mt-md-3">
                                <textarea onblur="proverkaResheniya()" oninput="proverkaResheniya()" id="resheniyamessage" class="control__textarea" placeholder="Сообщение"></textarea>
                            </div>
                            <div class="text-center">
                                <button id="buttonsendreshen" type="button" onclick="getAjaxContactForm('2', document.getElementById('resheniyaname').value, document.getElementById('resheniyamessage').value, document.getElementById('resheniyaphone').value, document.getElementById('resheniyaemail').value);" data-target="#modal-3" data-toggle="modal" class="button -bordered form__button" disabled>отправить</button>
                            </div>
                        </form>
                        <script>
                            function proverkaResheniya() {
                                nameResh=nm(document.getElementById('resheniyaname').value);
                                messResh=nm(document.getElementById('resheniyamessage').value);
                                telResh=ph(document.getElementById('resheniyaphone').value);
                                emailResh=ff(document.getElementById('resheniyaemail').value);
                                if(emailResh==1 && telResh==1 && nameResh==1 && messResh==1) document.getElementById('buttonsendreshen').disabled = false; else document.getElementById('buttonsendreshen').disabled = true;
                            }
                            var emailResh=0;
                            var telResh=0;
                            var nameResh=0;
                            var messResh=0;
                        </script>
            </div>
        </div>
        <!--/. Page Content End -->
    </div>
    <!--/. Page End -->

</main>
<!--/. App Main End -->
<?php get_footer(); ?>