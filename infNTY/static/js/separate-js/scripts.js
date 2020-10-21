//'use strict';

$(function() {

    /*
    |--------------------------------------------------------------------------
    | Wow Js
    |--------------------------------------------------------------------------
    */

    var wow = new WOW();
    wow.init();

    /*
    |--------------------------------------------------------------------------
    | Counter
    |--------------------------------------------------------------------------
    */

    $('.jsCountStats').each(function(){
        $(this).attr("data-count", $(this).text());
    });

    $(".intro-about__stats").on("wow", function(){
        $('.jsCountStats').each(function (){
            $(this).stop().prop('Counter',0).animate({
                Counter: $(this).attr("data-count")
            },{	duration: 4000,
                easing: 'swing',
                step: function (now){
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Animate On Scroll Library
    |--------------------------------------------------------------------------
    */

    AOS.init();

    /*
    |--------------------------------------------------------------------------
    | Typed.js
    |--------------------------------------------------------------------------
    */

    $(function(){
        $(".page__header-title ").typed({

            stringsElement: $('#js-typed-strings'),

            // typing speed
            typeSpeed: 60,

            // time before typing starts
            startDelay: 0,

            // backspacing speed
            backSpeed: 0,

            // time before backspacing
            backDelay: 50,

            // loop
            loop: false,

            // false = infinite
            loopCount: false,

            // show cursor
            showCursor: true,

            // character for cursor
            cursorChar: "",

            // attribute to type (null == text)
            attr: null,

            // either html or text
            contentType: 'html',

            // call when done callback function
            callback: function() {

                setTimeout (function () {
                    $('.typed-effect + .typed-cursor').css({'opacity': '0', 'animation': 'none'});
                }, 1300);

            },

            // starting callback function before each string
            preStringTyped: function() {},

            //callback for every typed string
            onStringTyped: function() {},

            // callback for reset
            resetCallback: function() {}
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Mobile menu
    |--------------------------------------------------------------------------
    */

    $('.jsBurgerMenu').click(function() {
        $(this).toggleClass('-open');
        $('.menu').toggleClass('-show');
        if ($(this).hasClass('-open')) {
            $('body').css({"overflow": "hidden"});
        } else {
            $('body').css({"overflow": ""});
        }
    });

    $('.menu__close').click(function() {
        $('.menu').toggleClass('-show');
        $('body').css({"overflow": ""});
    });

    $('.menu__overlay').click(function() {
        $('.menu').toggleClass('-show');
        $('body').css({"overflow": ""});
    });

    /*
    |--------------------------------------------------------------------------
    | Responsive iframe inside bootstrap modal
    |--------------------------------------------------------------------------
    */

    let iframeModal = document.getElementById('iframe-modal');
    let iframeModalItem = iframeModal.querySelector('.jsBmEmbedItem');

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('jsBmButton')){
            let dataVideo = {
                'src': e.target.getAttribute('data-bmSrc'),
                //'height': e.target.getAttribute('data-bmHeight'),
                //'width': e.target.getAttribute('data-bmWidth')
            };

            for(let key in dataVideo){
                iframeModalItem.setAttribute(key, dataVideo[key]);
            };

            $('#iframe-modal').on('hidden.bs.modal', function(){
                iframeModalItem.innerHTML = '';
                iframeModalItem.setAttribute("src", "");
            });
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Smooth Scroll
    |--------------------------------------------------------------------------
    */

    $('.page-scroll').on('click', function(event) {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            let target = $(this.hash),
                speed = $(this).data("speed") || 800;
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 0
                }, speed);
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Sticky Header
    |--------------------------------------------------------------------------
    */

    var fixedBlocks = document.querySelectorAll('.sticky');

    function positionCalculation(index){
        var posTop = 0;
        for(var i = index; i > -1; i--){
            posTop += fixedBlocks[i].getBoundingClientRect().height;
        }
        return posTop;
    }

    function neighborHeight(i){
        if(i > 0){
            return fixedBlocks[i-1].getBoundingClientRect().top + fixedBlocks[i-1].getBoundingClientRect().height;
        }
        return 0;
    }

    function positionDetermination(){
        for(var i = 0; i < fixedBlocks.length; i++){
            if(fixedBlocks[i].getBoundingClientRect().top + window.pageYOffset  <= window.pageYOffset + neighborHeight(i)){
                if(!fixedBlocks[i].spacer){
                    fixedBlocks[i].spacer = document.createElement('div');
                    fixedBlocks[i].spacer.style.position = 'static';
                    fixedBlocks[i].spacer.style.width = fixedBlocks[i].getBoundingClientRect().width + 'px';
                    fixedBlocks[i].spacer.style.height = fixedBlocks[i].getBoundingClientRect().height + 'px';
                    fixedBlocks[i].spacer.style.display = 'block';
                    fixedBlocks[i].spacer.style.verticalAlign = 'baseline';
                    fixedBlocks[i].spacer.style.float = 'none';

                    fixedBlocks[i].parentNode.insertBefore(fixedBlocks[i].spacer, fixedBlocks[i]);
                }

                fixedBlocks[i].classList.add(fixedBlocks[i].dataset.classFixed);
                if(i > 0){
                    fixedBlocks[i].style.top =  positionCalculation(i-1) + 'px';
                }

                if(fixedBlocks[i].getBoundingClientRect().top <= fixedBlocks[i].spacer.getBoundingClientRect().top){
                    fixedBlocks[i].parentNode.removeChild(fixedBlocks[i].spacer);
                    fixedBlocks[i].classList.remove(fixedBlocks[i].dataset.classFixed);
                    fixedBlocks[i].spacer = null;
                }
            }
        };
    };

    positionDetermination();

    document.addEventListener('scroll', function(){
        positionDetermination();
    });

    /*
    |--------------------------------------------------------------------------
    | Spoiler Text
    |--------------------------------------------------------------------------
    */

    let containerHeight = document.querySelectorAll(".jsSpoilerInner");
    let uncoverLink = document.querySelectorAll(".jsSpoilerMore");

    for(let i = 0; i < containerHeight.length; i++){
        let openData = uncoverLink[i].dataset.open;
        let closeData = uncoverLink[i].dataset.close;
        let curHeight = containerHeight[i].dataset.height;

        uncoverLink[i].innerHTML = openData;
        containerHeight[i].style.maxHeight = curHeight + "px";

        uncoverLink[i].addEventListener("click", function(){
            if(containerHeight[i].classList.contains("-open")){

                containerHeight[i].classList.remove("-open");

                uncoverLink[i].innerHTML = openData;

                containerHeight[i].style.maxHeight = curHeight + "px";

            } else {
                containerHeight[i].removeAttribute("style");

                containerHeight[i].classList.add("-open");

                uncoverLink[i].innerHTML = closeData;

            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Entry Slider
    |--------------------------------------------------------------------------
    */

	let entrySlider = new Swiper('.jsEntrySlider', {
		speed: 1200,
		mousewheel: false,
		loop: true,
		autoplay: {
			delay: 3000,
			disableOnInteraction: false,
		},
		spaceBetween: 0,
		slidesPerView: 1,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
	});

    /*
    |--------------------------------------------------------------------------
    | Light Gallery
    |--------------------------------------------------------------------------
    */

	$('.lg').lightGallery({
		//selector: ".lg__item",
	});

    /*
    |--------------------------------------------------------------------------
    | Polyfill object-fit/object-position on <img>: IE9, IE10, IE11, Edge, Safari, ...
    | https://github.com/bfred-it/object-fit-images
    |--------------------------------------------------------------------------
    */

    objectFitImages();
    // if you use jQuery, the code is: $(function () { objectFitImages() });

});
