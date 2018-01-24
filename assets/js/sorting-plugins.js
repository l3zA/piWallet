(function($){

    'use strict';

    var isAscending = true;

    var methods = {
        init:function(){
            var $this = this;
            return this.find('thead th').each(function(x){
                var th = $(this);
                (function (i) {
                    $(th).bind('click', function () {
                        sortListener(i, $this);
                    }).css('cursor', 'pointer');
                })(x);
            });
        },
        destroy: function () {
            return this.find('thead th').each(function(){
                $(this).unbind();
            })
        }
    }

    $.fn.sortTable = function(method) {
        if(methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method == 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('This method ' + method + ' is absent.');
        }
    }

    function sortListener(i, $this) {
        var rows = $($this).find('tbody tr').clone();
        rows.sort(function(a, b) {
            var tdFirst = $(a).find('td')[i];
            var valueFirst = $(tdFirst).html().trim();
            var tdSecond = $(b).find('td')[i];
            var valueSecond = $(tdSecond).html().trim();
            if(valueFirst > valueSecond){
                return (isAscending) ? 1 : -1;
            } else if(valueFirst == valueSecond) {
                return 0;
            } else {
                return (isAscending) ? -1 : 1;
            }
        });
        isAscending = !isAscending;
        $($this).find('tbody tr').remove();
        $($this).find('tbody').append(rows);
    }

})(jQuery);

