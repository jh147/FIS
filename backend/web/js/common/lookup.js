define(function (require, exports, module) {
    require('/js/common/grid.js');

    jQuery.fn.lookup = function (options) {
        var lookup = $(this),
            //未选择则清空，已选值，默认为true保持原有效果
            autoClear = options.autoClear!=undefined?options.autoClear:true,
            autoHide = options.autoHide!=undefined?options.autoHide:true,
            lookup_grid = $('#' + options.gridid),
            clearIcon = lookup.find('.x-icon-clear').eq(0),
            searchInput = $('#' + options.searchInput),
            placeholder = searchInput.attr('placeholder'),
            searchHiddenInput = $('#' + (options.searchHiddenInput?options.searchHiddenInput:(options.searchInput + '_id')));

        var isIE9 = navigator.userAgent.indexOf('MSIE 9.0')>-1;

        lookup_grid.css('height',36*(options.pagesize || 10));

        var isgridshow = false, lastInput = '';

        var supportPlace = ('placeholder' in document.createElement('input'));
        
        var isEmpty = function(){
            var inputVal = $.trim(searchInput.val());
            return inputVal=='' || (!supportPlace && inputVal == placeholder);
        };

        /**
         * 覆盖鼠标滚动事件
         * @param dom
         */
        var preventScroll = function(dom){
            if(dom.jquery){
                dom = dom.get(0);
            }
            if(navigator.userAgent.indexOf('Firefox') >= 0){   //firefox
                dom.addEventListener('DOMMouseScroll',function(e){
                    dom.scrollTop += e.detail > 0 ? 60 : -60;
                    e.preventDefault();
                },false);
            }else{
                dom.onmousewheel = function(e){
                    e = e || window.event;
                    dom.scrollTop += e.wheelDelta > 0 ? -60 : 60;
                    return false;
                };
            }
        };

        preventScroll(lookup_grid);

        var gridapp = lookup_grid.grid({
            url: options.gridDataUrl,
            idField: options.idField || 'id',
            templateid: options.gridTemplateId,
            pagesize: options.pagesize,
            searchText:'数据查询中...',
            emptyText: '',
            queryParams: options.queryParams || null,
            method:options.method||'get',
            scrollLoad:true,
            scrollWrapId:options.gridid,
            noAutoload: true,
            onRowClick: function (model,event) {
                event.stopPropagation();
                searchInput.val(model.get(options.valueField));
                searchHiddenInput.val(model.get(options.idField));
                searchInput.attr('data-value',model.get(options.valueField));
                lastInput = model.get(options.valueField);

                autoHide&&hidegrid();
                clearIcon.show();

                if (options.onRowClick) {
                    options.onRowClick(model);
                }
            }
        });


        var clearSearch = function(){
            searchInput.val('');
            if(!supportPlace){
                searchInput.val(placeholder);
            }
            searchInput.attr('data-value','');
            searchHiddenInput.val('');
            clearIcon.hide();

            if (options.onClear) {
                options.onClear();
            }
        };

        var queryAll = function(){
            var tempInput = searchInput.val();
            searchInput.val('');
            gridapp.search();
            searchInput.val(tempInput);
        };

        //输入框有默认值
        if(!isEmpty()){
            var defaultInput = $.trim(searchInput.val());
            lastInput = defaultInput;
            searchInput.attr('data-value',defaultInput);
            clearIcon.show();
        }

        var showgrid = function(){
            lookup_grid.show();
            isgridshow = true;
        };

        var hidegrid= function(){
            lookup_grid.hide();
            isgridshow = false;
        };


        //打开
        searchInput.focus(function () {
            var nowInput = $.trim(searchInput.val());
            if(!isgridshow&&!isEmpty()&&nowInput!=lastInput){
                lastInput = nowInput;
                searchInput.attr('data-value',nowInput);
                clearIcon.show();
            }

            showgrid();
            if(isEmpty()){
                searchInput.val('');
            }
            queryAll();
        });

        searchInput.blur(function () {
            if($.trim(searchInput.val()) ==='' && !supportPlace){
                searchInput.val(placeholder);
            }
        });
        
        //输入
        var _oninput = function(){
            var nowInput = ($.trim(searchInput.val()) == placeholder) ? '' : $.trim(searchInput.val());
            console.log(nowInput +':'+ $.trim(lastInput))
            if(isgridshow && nowInput!=$.trim(lastInput) && nowInput!= placeholder){
                lastInput = nowInput;
                isEmpty() ? clearIcon.hide() : clearIcon.show();
                gridapp.search();
            }
        };
        
        searchInput.on('input propertychange', function () {
            if(!isIE9&&$(this).prop('comStart')) return; 
            _oninput();         
        }).on('compositionstart', function(){
            $(this).prop('comStart', true);
        }).on('compositionend', function(){
            $(this).prop('comStart', false);
        });
        
        /*修复IE9 bug: 退格删除、右键剪切等不触发input事件*/
        if(isIE9){
            searchInput.on('keyup',function(event){
                if(event.which==8 || event.which==46){ //backspace、delete
                    if($(this).prop('comStart')) return; 
                    _oninput();
                }
            });
        }
        
        //关闭
        lookup.on('click', '.fonticon-search,.search-icon,#' + options.searchInput + ',#' + options.gridid + ' thead' + ',#' + options.gridid + ' tfoot', function (e) {
            e.stopPropagation();
        });

        
        $('body').on('click', function () {
            if(!isgridshow) return;
            autoHide&&hidegrid();
            var oldVal = searchInput.attr('data-value') || '';
            var newVal = $.trim(searchInput.val());
            if(newVal!=oldVal){
                searchInput.val(oldVal);
            }

            if(searchInput.val()==''){
                clearSearch();
            }

            lastInput = ($.trim(searchInput.val()) == placeholder) ? '' : $.trim(searchInput.val());
            isEmpty() ? clearIcon.hide() : clearIcon.show();  
        }); 

        clearIcon.on('click',function(e){
            clearSearch();
            hidegrid();
            lastInput = ($.trim(searchInput.val()) == placeholder) ? '' : $.trim(searchInput.val());
            e.stopPropagation();
        });


        return {
            hide: function () {
                hidegrid();
            }
        };
    };
});