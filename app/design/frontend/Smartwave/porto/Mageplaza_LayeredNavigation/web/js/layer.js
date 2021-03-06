/**
 * Copyright 2016 Mageplaza. All rights reserved.
 * See https://www.mageplaza.com/LICENSE.txt for license details.
 */
define([
    'jquery',
    'jquery/ui',
    'productListToolbarForm'
], function ($) {
    "use strict";

    $.widget('mageplaza.layer', {

        options: {
            productsListSelector: '#layer-product-list',
            navigationSelector: '#layered-filter-block'
        },

        _create: function () {
            this.initProductListUrl();
            this.initObserve();
            this.initLoading();
        },

        initProductListUrl: function () {
            var self = this;
            $.mage.productListToolbarForm.prototype.changeUrl = function (paramName, paramValue, defaultValue) {
                var urlPaths = this.options.url.split('?'),
                    baseUrl = urlPaths[0],
                    urlParams = urlPaths[1] ? urlPaths[1].split('&') : [],
                    paramData = {},
                    parameters;
                for (var i = 0; i < urlParams.length; i++) {
                    parameters = urlParams[i].split('=');
                    paramData[parameters[0]] = parameters[1] !== undefined
                        ? window.decodeURIComponent(parameters[1].replace(/\+/g, '%20'))
                        : '';
                }
                paramData[paramName] = paramValue;
                if (paramValue == defaultValue) {
                    delete paramData[paramName];
                }
                paramData = $.param(paramData);

                self.ajaxSubmit(baseUrl + (paramData.length ? '?' + paramData : ''));
            }
        },

        initObserve: function () {
            var self = this;
            var aElements = this.element.find('a');
            aElements.each(function (index) {
                var el = $(this);
                var link = self.checkUrl(el.prop('href'));
                if(!link) return;

                el.bind('click', function (e) {
                    if (el.hasClass('swatch-option-link-layered')) {
                        var childEl = el.find('.swatch-option');
                        childEl.addClass('selected');
                    } else {
                        var checkboxEl = el.find('input[type=checkbox]');
                        checkboxEl.prop('checked', !checkboxEl.prop('checked'));
                    }

                    self.ajaxSubmit(link);
                    e.stopPropagation();
                    e.preventDefault();
                });

                var checkbox = el.find('input[type=checkbox]');
                checkbox.bind('click', function (e) {
                    self.ajaxSubmit(link);
                    e.stopPropagation();
                });
            });

            $(".filter-current a").bind('click', function (e) {
                var link = self.checkUrl($(this).prop('href'));
                if(!link) return;

                self.ajaxSubmit(link);
                e.stopPropagation();
                e.preventDefault();
            });

            $(".filter-actions a").bind('click', function (e) {
                var link = self.checkUrl($(this).prop('href'));
                if(!link) return;

                self.ajaxSubmit(link);
                e.stopPropagation();
                e.preventDefault();
            });
        },

        checkUrl: function (url) {
            var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;

            return regex.test(url) ? url : null;
        },

        initLoading: function () {

        },

        ajaxSubmit: function (submitUrl) {
            var self = this;

            $.ajax({
                url: submitUrl,
                data: {isAjax: 1},
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $('.ln_overlay').show();
                    if (typeof window.history.pushState === 'function') {
                        window.history.pushState({url: submitUrl}, '', submitUrl);
                    }
                },
                success: function (res) {
                    if (res.backUrl) {
                        window.location = res.backUrl;
                        return;
                    }
                    if (res.navigation) {
                        $(self.options.navigationSelector).replaceWith(res.navigation);
                        $(self.options.navigationSelector).trigger('contentUpdated');
                    }
                    if (res.products) {
                        $(self.options.productsListSelector).replaceWith(res.products);
                        $(self.options.productsListSelector).trigger('contentUpdated');
                    }
                    $('.ln_overlay').hide();
                    if(typeof enable_quickview != 'undefined' && enable_quickview == true) {
                        requirejs(['jquery', 'weltpixel_quickview' ],
                        function   ($, quickview) {
                            $('.weltpixel-quickview').off('click').on('click', function() {
                                var prodUrl = $(this).attr('data-quickview-url');
                                if (prodUrl.length) {
                                    quickview.displayContent(prodUrl);
                                }
                            });
                        });
                    }
                    $(".products-grid .weltpixel-quickview").each(function(){
                        $(this).appendTo($(this).parent().parent().children(".product-item-photo"));
                    });
                },
                error: function () {
                    window.location.reload();
                }
            });
        }
    });

    return $.mageplaza.layer;
});
