/*!
 * HTML5 Query libray
 * https://github.com/Visolleon/H5Query
 * Author : Wang Yu Xiang
 * Weibo : http://weibo.com/visolleon
 * Blog : http://www.cnblogs.com/visolleon
 * Email : visolleon@gmail.com
 * Date : 2012-08-20
 */
(function (global){
    var _Q = function (obj){
        var _eles = null;

        if(typeof(obj) == 'string'){
            _eles = document.querySelectorAll(obj);
        }
        else{
            _eles = obj;
        }
        return {
            0: _eles,
            html : function (html){
                if(_eles && _eles.length > 0){
                    if(arguments.length == 1){
                        for (var i = 0; i < _eles.length; i++) {
                            _eles[i].innerHTML = html;
                        };
                    }
                    else{
                        return _eles[0].innerHTML;
                    }
                }
            },

            eq : function(i) {
                return _Q(_eles[i]);
            },

            get : function(i){
                return _eles[i];
            },

            css : function (name, value){
                if(_eles && _eles.length > 0){
                    if(arguments.length == 2) {
                        _eles[0].style[name] = value;
                    }
                    else{
                        var computedStyle = window.getComputedStyle(_eles[0])
                        return computedStyle ? computedStyle[name] : null;
                    }
                }
            },

            append : function (object){
                if(_eles && _eles.length > 0){
                    for (var i = 0; i < _eles.length; i++) {
                        _eles[i].appendChild(object);
                    }
                }
            },

            remove : function (object){
                if(_eles && _eles.length > 0){
                    for (var i = 0; i < _eles.length; i++) {
                        if(_eles[i].parentNode){
                            _eles[i].parentNode.removeChild(_eles[i]);
                        }
                        else{
                            document.body.removeChild(_eles[i]);
                        }
                    };
                }
            },

            insert : function (param){
                if(_eles && _eles.length > 0){
                    for (var i = 0; i < _eles.length; i++) {
                        var object = document.createElement(param.type);
                        if(param.id) object.id = param.id;
                        if(param.class) object.className = param.class;
                        if(param.html) object.innerHTML = param.html;
                        _eles[i].appendChild(object);
                    }
                }
            },

            click : function (fn){
                this.bind('click', fn);
            },

            bind : function(type, fn){
                if(_eles && _eles.length > 0){
                    for (var i = 0; i < _eles.length; i++) {
                        _eles[i].addEventListener( type, fn );
                    }
                }
            },

            attr : function(name, value){
                if(arguments.length == 2){
                    this.each(function(i){
                        this.setAttribute(name, value);
                    });
                }
                else{
                    if(_eles && _eles.length > 0)
                        return _eles[0].getAttribute(name);
                }
                return null;
            },

            hover : function(on, out){
                this.bind('mouseover', on);
                this.bind('mouseout', out);
            },

            each : function(fn){
                if( _eles != null ) {
                    for (var i = 0; i < _eles.length; i++) {
                        fn.bind(_eles[i])(i);
                    };
                }
            },

            addClass : function(classname){
                this.each(function(){
                    var c = $(this).attr('class');
                    if(c) {
                        if ( c.indexOf(classname) == -1 ) {
                            if(c)
                                c += ' ' + classname;
                            else
                                c = classname;
                        }
                    }
                    else
                        c = classname;
                    $(this).attr('class', c);
                });
            },

            removeClass : function (classname) {
                this.each(function(){
                    var c = $(this).attr('class');
                    if(c && c.indexOf(classname) != -1)
                        $(this).attr('class', c.replace(classname, ''));
                });
            },

            toggleClass : function (c1, c2) {
                this.each(function(){
                    var c = $(this).attr('class');
                    if(arguments.length >= 2){
                        if(c.indexOf(c1) != -1) {
                            $(this).removeClass(c1);
                            $(this).addClass(c2);
                        }
                        else{
                            $(this).removeClass(c2);
                            $(this).addClass(c1);
                        }
                    }
                    else{
                        if(c.indexOf(c1) != -1)
                            $(this).removeClass(c1);
                        else
                            $(this).addClass(c1);
                    }
                });
            },

            index : function (obj) {
                var index = -1;
                for(var i = 0; i <= _eles.length; i++) {
                    if(_eles[i] === obj) {
                        index = i;
                        break;
                    }
                }
                return index;
            },

            show : function (){
                this.css('display', 'block');
            },

            hide : function (){
                this.css('display', 'none');
            },

            width: function (){
                if(_eles && _eles.length > 0){
                    return _eles[0].offsetWidth;
                } else {
                    return 0;
                }
            },

            height: function() {
                if(_eles && _eles.length > 0){
                    return _eles[0].offsetHeight;
                } else {
                    return 0;
                }
            }
        };
    };

    // the bind method for function object
    if (!Function.prototype.bind) {
        Function.prototype.bind = function (oThis) {
            if (typeof this !== "function") {
              // closest thing possible to the ECMAScript 5 internal IsCallable function
              throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
            }

            var aArgs = Array.prototype.slice.call(arguments, 1),
                fToBind = this,
                fNOP = function () {},
                fBound = function () {
                  return fToBind.apply(this instanceof fNOP
                                         ? this
                                         : oThis,
                                       aArgs.concat(Array.prototype.slice.call(arguments)));
                };

            fNOP.prototype = this.prototype;
            fBound.prototype = new fNOP();

            return fBound;
        };
    }

    var Extends = {
        Insert : function (param) {
            var object = document.createElement(param.type);
            if(param.id) object.id = param.id;
            if(param.class) object.className = param.class;
            if(param.html) object.innerHTML = param.html;
            if(param.parent) {
                param.parent.append(object);
            }
            else{
                document.body.appendChild(object);
            }
        },

        LoadImage : function (url, callback) {
            var img = new Image();
            var superarg = arguments;
            img.onload = function () {
                if (callback) callback();
            };
            img.onerror = function(e){
                console.log(e);
                superarg.callee(url, callback);
            };
            img.src = url;
        }
    };

    for (var item in Extends) {
        _Q[item] = Extends[item];
    };

    global.query = global.$ = _Q;
})(window);
