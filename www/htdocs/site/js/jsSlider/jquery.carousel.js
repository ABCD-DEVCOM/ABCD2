;(function($){

    $.fn.carousel = function(params){

        var params = $.extend({
            direction: "horizontal",
            loop: false,
            dispItems: 1,
            pagination: false,
            paginationPosition: "inside",
            nextBtn: "<span>Next</span>",
            prevBtn: "<span>Previous</span>",
            btnsPosition: "inside",
            nextBtnInsert: "appendTo",
            prevBtnInsert: "prependTo",
            autoSlide: false,
            autoSlideInterval: 3000,
            delayAutoSlide: 3000,
            combinedClasses: false,
            effect: "slide",
            slideEasing: "swing",
            animSpeed: "normal",
            equalWidths: "true",
            callback: function(){}
        }, params);

        if (params.btnsPosition == "outside"){
            params.prevBtnInsert = "insertBefore";
            params.nextBtnInsert = "insertAfter";
        }

        return this.each(function(){

            // Env object
            var env = {
                $elts: {},
                params: params,
                launchOnLoad: []
            };

            // Carousel main container
            env.$elts.carousel = $(this).addClass("js");

            // Carousel content
            env.$elts.content = $(this).children().css({position: "absolute", "top": 0});

            // Content wrapper
            env.$elts.wrap = env.$elts.content.wrap('<div class="carousel-wrap"></div>').parent().css({overflow: "hidden", position: "relative"});

            // env.steps object
            env.steps = {
                first: 0, // First step
                count: env.$elts.content.find(">*").length // Items count
            };

            // Last visible step
            env.steps.last = env.steps.count - 1;

            // Next / Prev Buttons
            env.$elts.prevBtn = $(params.prevBtn)[params.prevBtnInsert](env.$elts.carousel).addClass("carousel-control previous carousel-previous").data("firstStep", -(env.params.dispItems));
            env.$elts.nextBtn = $(params.nextBtn)[params.nextBtnInsert](env.$elts.carousel).addClass("carousel-control next carousel-next").data("firstStep", env.params.dispItems);

            // Bind events on next / prev buttons
            initButtonsEvents(env, function(e){
                slide(e, this, env);
            });

            // Pagination
            if (env.params.pagination) initPagination(env);

            // On document+css load !
            $(function(){

                // First item
                var $firstItem = env.$elts.content.find(">*:eq(0)");

                // Width 1/1 : Get default item width
                env.itemWidth = $firstItem.outerWidth();

                // Width 2/3 : Define content width

                if (params.direction == "vertical"){
                    env.contentWidth = env.itemWidth;
                } else {
                    if (params.equalWidths) {
                        env.contentWidth = env.itemWidth * env.steps.count;
                    } else {
                        env.contentWidth = (function(){
                                            var totalWidth = 0;

                                            env.$elts.content.find(">*").each(function(){
                                                totalWidth += $(this).outerWidth();
                                            });

                                            return totalWidth;
                                        })();
                    }
                }

                // Width 3/3 : Set content width to container
                env.$elts.content.width( env.contentWidth );

                // Height 1/2 : Get default item height
                env.itemHeight = $firstItem.outerHeight();

                // Height 2/2 : Set content height to container
                if (params.direction == "vertical"){
                    env.$elts.content.css({height:env.itemHeight * env.steps.count + "px"});
                    env.$elts.content.parent().css({height:env.itemHeight * env.params.dispItems + "px"});
                } else {
                    env.$elts.content.parent().css({height:env.itemHeight});
                }

                // Update Next / Prev buttons state
                updateButtonsState(env);

                // Launch function added to "document ready" event
                $.each(env.launchOnLoad, function(i,fn){
                    fn();
                });

                // Launch autoslide
                if (env.params.autoSlide){
                    window.setTimeout(function(){
                        env.autoSlideInterval = window.setInterval(function(){
                            env.$elts.nextBtn.click();
                        }, env.params.autoSlideInterval);
                    }, env.params.delayAutoSlide);
                }

            });

        });

    };

    // Slide effect
    function slide(e, btn, env){
        var $btn = $(btn);
        var newFirstStep = $btn.data("firstStep");

        env.params.callback(newFirstStep);

        // Effect
        switch (env.params.effect){

            // No effect
            case "no":
                if (env.params.direction == "vertical"){
                    env.$elts.content.css("top", -(env.itemHeight * newFirstStep) + "px");
                } else {
                    env.$elts.content.css("left", -(env.itemWidth * newFirstStep) + "px");
                }
                break;

            // Fade effect
            case "fade":
                if (env.params.direction == "vertical"){
                    env.$elts.content.hide().css("top", -(env.itemHeight * newFirstStep) + "px").fadeIn(env.params.animSpeed);
                } else {
                    env.$elts.content.hide().css("left", -(env.itemWidth * newFirstStep) + "px").fadeIn(env.params.animSpeed);
                }
                break;

            // Slide effect
            default:
                if (env.params.direction == "vertical"){
                    env.$elts.content.stop().animate({
                        top : -(env.itemHeight * newFirstStep) + "px"
                    }, env.params.animSpeed, env.params.slideEasing);
                } else {
                    env.$elts.content.stop().animate({
                        left : -(env.itemWidth * newFirstStep) + "px"
                    }, env.params.animSpeed, env.params.slideEasing);
                }
        }

        env.steps.first = newFirstStep;

        updateButtonsState(env);

        // Stop autoslide
        if (!!e.clientX && env.autoSlideInterval){
            window.clearInterval(env.autoSlideInterval);
        }
    };

    // Update all buttons state : disabled or not
    function updateButtonsState(env){

        env.$elts.prevBtn.data("firstStep", env.steps.first - env.params.dispItems);
        env.$elts.nextBtn.data("firstStep", env.steps.first + env.params.dispItems);

        if (env.$elts.prevBtn.data("firstStep") < 0) {

            if (env.params.loop && env.steps.count > env.params.dispItems) {
                env.$elts.prevBtn.data("firstStep", env.steps.count - env.params.dispItems);
                env.$elts.prevBtn.trigger("enable");
            } else {
                env.$elts.prevBtn.trigger("disable");
            }

        } else {
            env.$elts.prevBtn.trigger("enable");
        }

        if (env.$elts.nextBtn.data("firstStep") >= env.steps.count) {

            if (env.params.loop && env.steps.count > env.params.dispItems) {
                env.$elts.nextBtn.data("firstStep", 0);
                env.$elts.nextBtn.trigger("enable");
            } else {
                env.$elts.nextBtn.trigger("disable");
            }

        } else {
            env.$elts.nextBtn.trigger("enable");
        }

        if (env.params.pagination){
            env.$elts.paginationBtns.removeClass("active")
            .filter(function(){ return ($(this).data("firstStep") == env.steps.first) }).addClass("active");
        }
    };

    // Next / Prev buttons events only
    function initButtonsEvents(env, slideEvent){

        env.$elts.nextBtn.add(env.$elts.prevBtn)
        .bind("enable", function(){
            var $this = $(this).bind("click", slideEvent).removeClass("disabled");
            // Combined classes : IE6 compatibility
            if (env.params.combinedClasses) {
                $this.removeClass("next-disabled previous-disabled");
            }
        })
        .bind("disable", function(){
            var $this = $(this).unbind("click").addClass("disabled");

            // Combined classes : IE6 compatibility
            if (env.params.combinedClasses) {

                if ($this.is(".next")) {
                    $this.addClass("next-disabled");

                } else if ($this.is(".previous")) {
                    $this.addClass("previous-disabled");

                }
            }
        });

        env.$elts.nextBtn.add(env.$elts.prevBtn).hover(
            function(){
                $(this).addClass("hover");
            },
            function(){
                $(this).removeClass("hover");
            }
        );
    };

    // Pagination
    function initPagination(env){
        env.$elts.pagination = $('<div class="center-wrap"><div class="carousel-pagination"><p></p></div></div>')[((env.params.paginationPosition == "outside")? "insertAfter" : "appendTo")](env.$elts.carousel).find("p");

        env.$elts.paginationBtns = $([]);

        env.$elts.content.find("li").each(function(i){
            if (i % env.params.dispItems == 0) {
                env.$elts.paginationBtns = env.$elts.paginationBtns.add( $('<a role="button"><span>'+( env.$elts.paginationBtns.length + 1 )+'</span></a>').data("firstStep", i) );
            }
        });

        env.$elts.paginationBtns.appendTo(env.$elts.pagination);

        env.$elts.paginationBtns.slice(0,1).addClass("active");

        // Events
        env.launchOnLoad.push(function(){
            env.$elts.paginationBtns.click(function(e){
                slide( e, this, env);
            });
        });
    };

})(jQuery);