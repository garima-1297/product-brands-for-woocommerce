jQuery(document).ready(function($)
{
    jQuery('select.widefat option[value="0"]').attr('selected', 'selected');
    jQuery('select.productBrand option[value="0"]').attr('selected', 'selected');
    jQuery(document).on('change', 'select.widefat', function(e)
    {
        e.preventDefault();
        var brandValue = jQuery("select.productBrand").find('option:selected').val();
        var value = jQuery(this).val();
        var column = jQuery('input[name="column"]').val();
        var price = jQuery('input[name="price"]').val();
        var new_selection = jQuery('select.widefat').find('option:selected');
        //jQuery('option').not(new_selection).removeAttr('selected');
        new_selection.attr("selected", true);
        jQuery.ajax(
        {
            type: "POST",
            url: ajaxurl,
            data:
            {
                "action": "pbw_filter_products_by_brand_module",
                "product_category": value,
                "product_brand": brandValue,
                "column": column,
                "price": price,
            },
            beforeSend: function()
            {
                jQuery(".prod-response").html('<div></div>')
            },
            success: function(response)
            {
                //console.log(response);
                if (value == '0' && brandValue == '0') {
                    jQuery(".prod-response").hide();
                    jQuery(".all-products").show();
                } else {
                    jQuery(".prod-response").show();
                    jQuery(".all-products").hide();
                }
                jQuery(".prod-response").append(response);
            }
        });
    });
    jQuery(document).on('change', 'select.productBrand', function(e)
    {
        e.preventDefault();
        var prodValue = jQuery("select.widefat").find('option:selected').val();
        var brandValue = jQuery(this).val();
        var column = jQuery('input[name="column"]').val();
        var price = jQuery('input[name="price"]').val();
        var new_selection = jQuery('select.productBrand').find('option:selected');
        new_selection.attr("selected", true);
        jQuery.ajax(
        {
            type: "POST",
            url: ajaxurl,
            data:
            {
                "action": "pbw_filter_products_by_brand_module",
                "product_brand": brandValue,
                "product_category": prodValue,
                "column": column,
                "price": price,
            },
            beforeSend: function()
            {
                jQuery(".prod-response").html('<div></div>')
            },
            success: function(response)
            {
                if (brandValue == '0' && prodValue == '0') {
                    jQuery(".prod-response").hide();
                    jQuery(".all-products").show();
                } else {
                    jQuery(".prod-response").show();
                    jQuery(".all-products").hide();
                }
                jQuery(".prod-response").append(response);
            }
        });
    });
    jQuery(document).on('change', 'select.pbb-with-text', function(e)
    {
        e.preventDefault();
        var brandValue = jQuery("select.productBrand-text").find('option:selected').val();
        var value = jQuery(this).val();
        var id = jQuery('ul.all-products input[name="prod_id"]').val();
        var new_selection = jQuery('select.pbb-with-text').find('option:selected');
        new_selection.attr("selected", true);
        jQuery.ajax(
        {
            type: "POST",
            url: ajaxurl,
            data:
            {
                "action": "filter_products_by_brand_module_with_text",
                "product_category": value,
                "product_brand": brandValue,
            },
            beforeSend: function()
            {
                jQuery(".response").html('<div></div>')
            },
            success: function(response)
            {
                //console.log(response);
                if (value == '0' && brandValue == '0') {
                    jQuery(".response").hide();
                    jQuery(".brand-wrapper").show();
                } else {
                    jQuery(".response").show();
                    jQuery(".brand-wrapper").hide();
                }
                jQuery(".response").append(response);
            }
        });
    });
    jQuery(document).on('change', 'select.productBrand-text', function(e)
    {
        e.preventDefault();
        var prodValue = jQuery("select.pbb-with-text").find('option:selected').val();
        var brandValue = jQuery(this).val();
        var id = jQuery('input[name="prod_id"]').val();
        console.log(id);
        var new_selection = jQuery('select.productBrand-text').find('option:selected');
        new_selection.attr("selected", true);
        jQuery.ajax(
        {
            type: "POST",
            url: ajaxurl,
            data:
            {
                "action": "filter_products_by_brand_module_with_text",
                "product_brand": brandValue,
                "product_category": prodValue,
            },
            beforeSend: function()
            {
                jQuery(".response").html('<div></div>')
            },
            success: function(response)
            {
                if (brandValue == '0' && prodValue == '0') {
                    jQuery(".response").hide();
                    jQuery(".brand-wrapper").show();
                } else {
                    jQuery(".response").show();
                    jQuery(".brand-wrapper").hide();
                }
                jQuery(".response").append(response);
            }
        });
    });
    jQuery('#filter_widget .letter').click(function()
    {
        if (jQuery(this).hasClass('wb-all-alphabet-item')) {
            jQuery('.tax-row').show();
        } else {
            jQuery('.tax-row').hide();
        }
        var id = jQuery(this).attr('id');
        jQuery('.' + id).show();
    });


    jQuery('#slider_1').css('visibility', 'visible');
    jQuery('#slider_1').bxSlider(
    {
        mode: 'vertical',
        touchEnabled: false,
        adaptiveHeight: false,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-cnt products wb-brandpro-style1 wb-carousel-style4 wb-carousel-skin-light',
        infiniteLoop: true,
        pager: true,
        controls: true,
        slideWidth: 310,
        minSlides: 1,
        maxSlides: 1,
        moveSlides: 1,
        auto: true,
        pause: 5000,
        autoHover: true,
        autoStart: true
    });
    jQuery('#slider_2').css('visibility', 'visible');
    jQuery('#slider_2').bxSlider(
    {
        mode: 'vertical',
        touchEnabled: false,
        adaptiveHeight: false,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-cnt products wb-brandpro-style2 wb-carousel-style1 wb-carousel-skin-dark',
        infiniteLoop: true,
        pager: true,
        controls: false,
        slideWidth: 310,
        minSlides: 1,
        maxSlides: 1,
        moveSlides: 1,
        auto: true,
        pause: 3000,
        autoHover: true,
        autoStart: true
    });
    jQuery('#slider_3').css('visibility', 'visible');
    jQuery('#slider_3').bxSlider(
    {
        mode: 'vertical',
        touchEnabled: false,
        adaptiveHeight: true,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-cnt products',
        infiniteLoop: true,
        pager: true,
        controls: false,
        slideWidth: 310,
        minSlides: 1,
        maxSlides: 1,
        moveSlides: 1,
        auto: true,
        pause: 4000,
        autoHover: true,
        autoStart: true
    });
    //hr_slider_1
    var hr_slider_1;
    jQuery('#hr_slider_1').css('visibility', 'visible');

    function buildSliderConfiguration4()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 375 && windowWidth <= 575)
        {
            numberOfVisibleSlides = 2;
        }
        else if (windowWidth >= 0 && windowWidth < 375)
        {
            numberOfVisibleSlides = 1;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-cnt products brand-horizontal-slider',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 3000,
            autoHover: true,
            autoStart: true
        };
    }

    function configureSlider4()
    {
        var config = buildSliderConfiguration4();
        if (hr_slider_1 && hr_slider_1.reloadSlider)
        {
            hr_slider_1.reloadSlider(config);
        }
        else
        {
            hr_slider_1 = $('#hr_slider_1').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider4);
    configureSlider4();

    //hr_slider_2
    var hr_slider_2;
    jQuery('#hr_slider_2').css('visibility', 'visible');

    function buildSliderConfiguration5()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 375 && windowWidth <= 575)
        {
            numberOfVisibleSlides = 2;
        }
        else if (windowWidth >= 0 && windowWidth < 375)
        {
            numberOfVisibleSlides = 1;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-cnt products wb-brandpro-style2 wb-carousel-style1 wb-carousel-skin-light brand-horizontal-slider',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 3000,
            autoHover: true,
            autoStart: true
        };
    }

    function configureSlider5()
    {
        var config = buildSliderConfiguration5();
        if (hr_slider_2 && hr_slider_2.reloadSlider)
        {
            hr_slider_2.reloadSlider(config);
        }
        else
        {
            hr_slider_2 = $('#hr_slider_2').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider5);
    configureSlider5();

    //hr_slider_3
    var hr_slider_3;
    jQuery('#hr_slider_3').css('visibility', 'visible');

    function buildSliderConfiguration6()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 375 && windowWidth <= 575)
        {
            numberOfVisibleSlides = 2;
        }
        else if (windowWidth >= 0 && windowWidth < 375)
        {
            numberOfVisibleSlides = 1;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-cnt products wb-brandpro-style1 wb-carousel-style3 wb-carousel-skin-dark brand-horizontal-slider',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 3000,
            autoHover: true,
            autoStart: true
        };
    }

    function configureSlider6()
    {
        var config = buildSliderConfiguration6();
        if (hr_slider_3 && hr_slider_3.reloadSlider)
        {
            hr_slider_3.reloadSlider(config);
        }
        else
        {
            hr_slider_3 = $('#hr_slider_3').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider6);
    configureSlider6();

    jQuery('#hr_slider_4').css('visibility', 'visible');
    jQuery('#hr_slider_4').bxSlider(
    {
        mode: 'horizontal',
        touchEnabled: false,
        adaptiveHeight: true,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-cnt products wb-brandpro-style2 wb-carousel-style4 wb-carousel-skin-light',
        infiniteLoop: true,
        pager: true,
        controls: true,
        slideWidth: 300,
        minSlides: 5,
        maxSlides: 5,
        moveSlides: 1,
        auto: true,
        pause: 3000,
        autoHover: true,
        autoStart: true
    });


    jQuery('#hr_slider_5').css('visibility', 'visible');
    var hr_slider_5, hr_slider_6, hr_slider_7, hr_slider_8;
    //hr_slider_5
    function buildSliderConfiguration()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 320 && windowWidth <= 575)
        {
            numberOfVisibleSlides = 2;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-carousel-style1 wb-carousel-skin1 brand-horizontal-slider',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 4000,
            autoHover: true,
            autoStart: true,
            responsive: true,
        };
    }

    function configureSlider()
    {
        var config = buildSliderConfiguration();
        if (hr_slider_5 && hr_slider_5.reloadSlider)
        {
            hr_slider_5.reloadSlider(config);
        }
        else
        {
            hr_slider_5 = $('#hr_slider_5').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider);
    configureSlider();

    //hr_slider_6
    jQuery('#hr_slider_6').css('visibility', 'visible');

    function buildSliderConfiguration2()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 320 && windowWidth <= 575)
        {
            numberOfVisibleSlides = 2;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-car-round wb-carousel-style3 wb-carousel-skin-light brand-horizontal-slider',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 3000,
            autoHover: true,
            autoStart: true,
            responsive: false,
        };
    }

    function configureSlider2()
    {
        var config = buildSliderConfiguration2();
        if (hr_slider_6 && hr_slider_6.reloadSlider)
        {
            hr_slider_6.reloadSlider(config);
        }
        else
        {
            hr_slider_6 = $('#hr_slider_6').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider2);
    configureSlider2();

    //hr_slider_7
    jQuery('#hr_slider_7').css('visibility', 'visible');

    function buildSliderConfiguration9()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth < 576)
        {
            numberOfVisibleSlides = 1;
        }
        else
        {
            numberOfVisibleSlides = 3;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 20,
            wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-carousel-style2 wb-carousel-skin-dark brand-horizontal-slider',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 3,
            auto: false,
            pause: 4000,
            autoHover: true,
            autoStart: true,
            responsive: false,
        };
    }

    function configureSlider9()
    {
        var config = buildSliderConfiguration9();
        if (hr_slider_7 && hr_slider_7.reloadSlider)
        {
            hr_slider_7.reloadSlider(config);
        }
        else
        {
            hr_slider_7 = $('#hr_slider_7').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider9);
    configureSlider9();

    //hr_slider_8
    jQuery('#hr_slider_8').css('visibility', 'visible');

    function buildSliderConfiguration3()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 320 && windowWidth <= 575)
        {
            numberOfVisibleSlides = 2;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-carousel-style1 wb-carousel-skin1 brand-horizontal-slider',
            infiniteLoop: true,
            pager: false,
            controls: false,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 2000,
            autoHover: true,
            autoStart: true,
            responsive: false,
        };
    }

    function configureSlider3()
    {
        var config = buildSliderConfiguration3();
        if (hr_slider_8 && hr_slider_8.reloadSlider)
        {
            hr_slider_8.reloadSlider(config);
        }
        else
        {
            hr_slider_8 = $('#hr_slider_8').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider3);
    configureSlider3();

    //fr_slider_1
    var fr_slider_1;
    jQuery('#fr_slider_1').css('visibility', 'visible');

    function buildSliderConfiguration7()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 320 && windowWidth < 576)
        {
            numberOfVisibleSlides = 2;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style4 wb-carousel-style4 wb-carousel-skin-light',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 4000,
            autoHover: true,
            autoStart: false,
            responsive: false,
        };
    }

    function configureSlider7()
    {
        var config = buildSliderConfiguration7();
        if (fr_slider_1 && fr_slider_1.reloadSlider)
        {
            fr_slider_1.reloadSlider(config);
        }
        else
        {
            fr_slider_1 = $('#fr_slider_1').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider7);
    configureSlider7();
    
    //fr_slider_2
    var fr_slider_2;
    jQuery('#fr_slider_2').css('visibility', 'visible');

    function buildSliderConfiguration8()
    {
        // When possible, you should cache calls to jQuery functions to improve performance.
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;
        if (windowWidth >= 576 && windowWidth <= 767)
        {
            numberOfVisibleSlides = 3;
        }
        else if (windowWidth >= 320 && windowWidth < 576)
        {
            numberOfVisibleSlides = 2;
        }
        else
        {
            numberOfVisibleSlides = 5;
        }
        return {
            mode: 'horizontal',
            touchEnabled: false,
            adaptiveHeight: true,
            slideMargin: 10,
            wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style1 wb-carousel-style3 wb-carousel-skin-light',
            infiniteLoop: true,
            pager: true,
            controls: true,
            slideWidth: 300,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            moveSlides: 1,
            auto: true,
            pause: 4000,
            autoHover: true,
            autoStart: true,
            responsive: false,
        };
    }

    function configureSlider8()
    {
        var config = buildSliderConfiguration8();
        if (fr_slider_2 && fr_slider_2.reloadSlider)
        {
            fr_slider_2.reloadSlider(config);
        }
        else
        {
            fr_slider_2 = $('#fr_slider_2').bxSlider(config);
        }
    }
    jQuery(window).on("orientationchange resize", configureSlider8);
    configureSlider8();
    jQuery('#vt_slider_1').css('visibility', 'visible');
    jQuery('#vt_slider_1').bxSlider(
    {
        mode: 'vertical',
        touchEnabled: false,
        adaptiveHeight: true,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-carousel-style2 wb-carousel-skin-light',
        infiniteLoop: true,
        pager: true,
        controls: true,
        slideWidth: 320,
        minSlides: 3,
        maxSlides: 3,
        moveSlides: 3,
        auto: true,
        pause: 3000,
        autoHover: true,
        autoStart: true,
        responsive: false,
    });
    jQuery('#vt_slider_2').css('visibility', 'visible');
    jQuery('#vt_slider_2').bxSlider(
    {
        mode: 'vertical',
        touchEnabled: false,
        adaptiveHeight: true,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-carousel-style1 wb-carousel-skin1',
        infiniteLoop: true,
        pager: true,
        controls: true,
        slideWidth: 320,
        minSlides: 3,
        maxSlides: 3,
        moveSlides: 3,
        auto: true,
        pause: 3000,
        autoHover: true,
        autoStart: true,
        responsive: false,
    });
    jQuery('#vt_slider_3').css('visibility', 'visible');
    jQuery('#vt_slider_3').bxSlider(
    {
        mode: 'vertical',
        touchEnabled: false,
        adaptiveHeight: true,
        slideMargin: 10,
        wrapperClass: 'wb-bx-wrapper wb-car-car wb-car-cnt wb-car-style2 wb-carousel-style3 wb-carousel-skin-dark',
        infiniteLoop: true,
        pager: true,
        controls: true,
        slideWidth: 320,
        minSlides: 3,
        maxSlides: 3,
        moveSlides: 3,
        auto: true,
        pause: 3000,
        autoHover: true,
        autoStart: true,
        responsive: false,
    });
});