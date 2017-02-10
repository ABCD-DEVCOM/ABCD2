;(function($){
    $.unobtrusivelib = function (enabled_modules) {

        var modules = {
            popup: function () {
                $("a[rel^=popup]").each(function (i) {
                    var popupName = 'popup_' + i + '_' + new Date().getTime();

                    $(this).click(function (e) {
                        e.preventDefault();
                        var dims = this.getAttribute('rel').match(/.*\[([0-9]+)-([0-9]+)\].*/);
                        window.open(this.getAttribute('href'), popupName, 'width=' + dims[1] + ',height=' + dims[2] + ',resizable,scrollbars');
                    });
                });
            },

            external: function () {
                $("a[rel~=external]").click(function(e){
                    e.preventDefault();
                    window.open(this.href);
                });
            },

            maxLength: function () {
                $("textarea[maxlength]").each(function(){
                    var jThis = $(this);
                    var sMaxLimit = jThis.attr("maxlength")-0;

                    if (jThis.hasClass("counter")) {
                        var jCount = $('<span class="counter">' + sMaxLimit + '</span>');
                        jThis.after(jCount);
                    }

                    jThis.keyup(function(e) {
                        var charCount = sMaxLimit - jThis.val().length;
                        if ( charCount < 1 ) {
                            jThis.val( jThis.val().slice(0, sMaxLimit) );
                        }
                        if ( !!jCount ) {
                            jCount.text(charCount);
                        }
                    });
                });
            },

            autoClearInput: function () {

                var defaultClass = "autoclear-default";

                $("input.autoclear:text, input.autoclear:password, textarea.autoclear").each(function(){

                    var $this = $(this);

                    if ($this.is(":password") && !$.browser.msie) {

                        var $original = $this;

                        $this = $this.clone().attr("type", "text").removeAttr("name");
                        $original.after($this).hide();

                        $this.focus(function(){
                            $this.hide();
                            $original.show().focus();
                        });

                        if ( $this.val() == this.defaultValue ) {
                            $this.addClass(defaultClass);
                        }

                        $original
                        .focus(function () {
                            if ( this.defaultValue == $original.val() ) {
                                $original.removeClass(defaultClass).val("");
                            }
                        })
                        .blur(function () {
                            if ( $original.val() == "" ) {
                                $original.hide();
                                $this.show().addClass(defaultClass).val( this.defaultValue );
                            }
                        });

                    } else {

                        if ( $this.val() == this.defaultValue ) {
                            $this.addClass(defaultClass);
                        }

                        $this
                        .focus(function () {
                            if ( this.defaultValue == $this.val() ) {
                                $this.removeClass(defaultClass).val("");
                            }
                        })
                        .blur(function () {
                            if ( $this.val() == "" ) {
                                $this.addClass(defaultClass).val( this.defaultValue );
                            }
                        });
                    }

                });
            },

            autoFocusInput: function () {
                var focusElmts = $("input.autofocus");
                if (focusElmts.length != 0){
                    focusElmts.get(0).focus();
                }
            }
        };

        if (!!enabled_modules) {
            $.each(enabled_modules,function(i,n){
                if(modules[n]){
                    modules[n]();
                }
            });
        }
        else {
            $.each(modules,function(i,n){n();});
        }

    };
})(jQuery);