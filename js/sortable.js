(function($){
$.p8_sortable = function (options) {

    this.options = $.extend(options, {
        selector: {
            range: options.selector.range ,
            drag: options.selector.drag || '',
            container: options.selector.container || ''
        },
        sort: options.sort || null,
        sorted: options.sorted || null,
        beforeSort: options.beforeSort || null,
        holder_css: options.holder_css || '',
        type: options.type || 'all'
    });
    this.drag_selector = this.options.selector.drag.length ? true : false;
    this.container_selector = this.options.selector.container.length ? true : false;
    this.holder = null;
    this.container_timeout = null;
    var _this = this;  
    this.refresh = function(){
        console.log(this.options.selector.range);
        var item = $(this.options.selector.range).parent();
        
        item.sortable({
            axis:_this.options.type,
            items:_this.options.selector.range,
            handle:_this.options.selector.drag,
            containmentType:"parent"
        });
            
    };
    this.refresh();
}
})(jQuery);