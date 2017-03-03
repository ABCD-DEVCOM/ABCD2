/*
 * jQuery Simple Tabs 1.0
 *
 * Copyright (c) 2008 Pierre Bertet (pierrebertet.net)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 */

/*
TODO :
    - Ajouter une méthode statique, du style : $.simpletabs("menu", "tabs_container")
*/

(function($){

    // TODO
    $.simpletabs = function(){};

    $.fn.simpletabs = function(params){

        var opts = $.extend({
            hideTags: false,
            activeTab: 1,
            activeClass: "active",
            mouseover: false,
            noresize: false,
            navParent: false,
            framesParent: false,
            activeAnchors: true,
            linksToInsideAnchors: []
        }, params);

        // Inside anchors
        opts.linksToInsideAnchors = $(opts.linksToInsideAnchors);

        opts.activeTab--;

        var currentTab = false;

        this.each(function(){

            // Selections
            var container = $(this);
            var nav_container = opts.navParent || container.find("> :first-child");
            var frames_container = opts.framesParent || container.find("> :nth-child(2)");

            var nav_links = nav_container.find("a[href^=#]");
            var frames = frames_container.find("> *");

            // Tabs count == frames count ?
            if (nav_links.length != frames.length){return false;}

            // Resize height
            if (!(opts.noresize)){
                $(window).load(function(){
                    var maxHeight = 0;
                    frames.each(function(){
                        var curHeight = $(this).height();
                        if (curHeight > maxHeight){maxHeight = curHeight;}
                    });
                    frames.height(maxHeight);
                });
            }

            // Prevent default event
            nav_links.click(function(e){
                e.preventDefault();
            });

            // Add frames to link properties
            nav_links.each(function(){

                var $nav_link = $(this);

                this._linkedFrame = frames.filter($nav_link.attr("href"));
                this._linkedFrame.get(0)._linkedTab = this;

                // External links to anchors
                if (opts.activeAnchors){
                    $("a[href="+ $nav_link.attr("href") +"]").not(this).click(function(e){
                        e.preventDefault();
                        $nav_link.click();
                        var scrollTop = nav_container.offset().top;
                        $("html")[0].scrollTop = scrollTop;
                    });
                }

            });

            // Switch tabs on click
            nav_links.click(function(){
                if (currentTab){
                    currentTab.removeClass(opts.activeClass);
                    currentTab.get(0)._linkedFrame.hide();
                }
                else {
                    frames.filter(":visible").hide();
                }

                this._linkedFrame.show();
                $(this).addClass(opts.activeClass);
                currentTab = $(this);
            });

            // And on mouseover
            if (opts.mouseover){
                nav_links.hover(function(){ // On mouseover
                    $(this).click();
                },function(){});
            }

            // Hide tags
            if (opts.hideTags){
                frames.find(opts.hideTags).hide();
            }

            // External links to inside anchors
            opts.linksToInsideAnchors.each(function(){
                var $link = $(this);
                frames.each(function(){
                    var $frame = $(this);
                    if ( $frame.find( $link.attr("href") ).length > 0 ){
                        $link.click(function(){
                            $($frame.get(0)._linkedTab).click();
                        });
                    }
                });
            });

            if (!!window.location.hash && frames.is(window.location.hash)){
                // Show anchor targeted tab
                nav_links.filter("[href=" + window.location.hash + "]").click();
            }
            else if (!!window.location.hash && opts.linksToInsideAnchors.is('[href='+window.location.hash+']')){
                // Show tab with anchor inside
                opts.linksToInsideAnchors.filter('[href='+window.location.hash+']').click();
            }
            else {
                // Show first tab
                nav_links.filter(":eq(" + opts.activeTab + ")").click();
            }
        });

        return this;
    };
})(jQuery);