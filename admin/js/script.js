/**
 * Initialize jQuery colorpicker
 *
 * @since       1.0.0
 * @package     Social Network Widget
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
( function( wp, $ ) {
    'use strict';

    if ( ! wp ) {
        return;
    } // End If Statement

    var timeout = null;
    var SNW = {

        cache: function() {
            SNW.els = {};
            SNW.vars = {};
            SNW.vars.widgetID = '[id*="social_network_widget"]';
            SNW.vars.widgetName = '[name*="social_network_widget"]';
            SNW.vars.colorpicker = '.social-network-widget-color-picker';
            SNW.vars.iconsList = '.social-network-icons-widget-list';
            SNW.vars.addBtnClassname = '.social-network-widget.add-button button';
            SNW.vars.removeBtnClassname = '.social-network-widget-item__wrapper__remove a';
        },

        // Run after the document is loaded
        ready: function() {
            SNW.cache();
            SNW.onAddClick();
            SNW.onRemoveClick();
            SNW.onOpen();
            SNW.onAdded();
            SNW.onUpdated();
            SNW.onFocusOut();
            SNW.onKeyDown();
            SNW.onKeyUp();
            SNW.onChange();
        },

        // Add an item.
        onAddClick: function() {
            $( document ).on( 'click', SNW.vars.addBtnClassname, function( event ) {
                // Default action of the event should not be triggered.
                event.preventDefault();
                // Prevents the event from bubbling up the DOM tree.
                event.stopPropagation();

                var template, widgetContent, widgetList, widgetLastItem, urlId, urlName;

                template = $( $.trim( $( '#tmpl-social-network-widget' ).html() ) );
                widgetContent = $( this ).parents( '.widget-content' );
                widgetList = widgetContent.find( SNW.vars.iconsList );
                urlId = widgetList.data( 'url-icon-id' );
                urlName = widgetList.data( 'url-icon-name' );
                template.find( '.social-network-widget-item__wrapper__url input' ).attr( 'id', urlId ).attr( 'name', urlName + '[]' );
                widgetList.append( template );
                widgetLastItem = widgetContent.find( '.social-network-widget-item:last' );
                widgetLastItem.find( 'input:first' ).trigger( 'focus' );
            } );
        },

        // Remove an item.
        onRemoveClick: function() {
            $( document ).on( 'click', SNW.vars.removeBtnClassname, function( event ) {
                // Default action of the event should not be triggered.
                event.preventDefault();
                // Prevents the event from bubbling up the DOM tree.
                event.stopPropagation();

                var button = $( this ).parents( '.form' ).find( '.widget-control-save' );
                $( this ).parents( '.social-network-widget-item' ).remove();
                SNW._livePreviewUpdate( button );
            } );
        },

        // Open button.
        onOpen: function() {
            $( document ).on( 'click', `div.widget${ SNW.vars.widgetID } .widget-title, div.widget${ SNW.vars.widgetID } .widget-action`, function() {
                if ( $( this ).parents( '#available-widgets' ).length > 0 ) {
                    return;
                } // End If Statement

                SNW._initWidget( $( this ).parents( `.widget${ SNW.vars.widgetID }` ) );
                SNW._initColorPicker( $( this ).parents( `.widget${ SNW.vars.widgetID }` ) );
            } );
        },

        onAdded: function() {
            $( document ).on( 'widget-added', function( event, widget ) {
                if ( widget.is( SNW.vars.widgetID ) ) {
                    // Default action of the event should not be triggered.
                    event.preventDefault();

                    SNW._initWidget( widget );
                    SNW._initColorPicker( $( this ).parents( `.widget${ SNW.vars.widgetID }` ) );
                } // End If Statement
            } );
        },

        onUpdated: function() {
            $( document ).on( 'widget-updated', function( event, widget ) {
                if ( widget.is( SNW.vars.widgetID ) ) {
                    // Default action of the event should not be triggered.
                    event.preventDefault();

                    SNW._initWidget( widget );
                    SNW._initColorPicker( $( this ) );
                } // End If Statement
            } );
        },

        // Live preview update on input focus out.
        onFocusOut: function() {
            $( document ).on( 'focusout', `input${ SNW.widgetName }`, function() {
                SNW._livePreviewUpdate(
                    $( this ).parents( '.form' ).find( '.widget-control-save' )
                );
            } );
        },

        // Live preview update on input focus out.
        onKeyDown: function() {
            $( document ).on( 'keydown', `input${ SNW.widgetName }`, function( event ) {
                if ( event.keyCode === 13 ) {
                    SNW._livePreviewUpdate(
                        $( this ).parents( '.form' ).find( '.widget-control-save' )
                    );
                } // End If Statement
            } );
        },

        // Live preview update on input focus out.
        onKeyUp: function() {
            $( document ).on( 'keyup', `input${ SNW.widgetName }`, function() {
                clearTimeout( timeout );

                timeout = setTimeout( function() {
                    SNW._livePreviewUpdate(
                        $( this ).parents( '.form' ).find( '.widget-control-save' )
                    );
                }, 1000 );
            } );
        },

        onChange: function() {
            $( document ).on( 'change', `select${ SNW.widgetName }`, function() {
                $( this ).parents( '.form' ).find( '.widget-control-save' );
            } );
        },

        _initWidget: function( widget ) {
            widget.find( SNW.vars.iconsList ).sortable( {
                items: '> .social-network-widget-item',
                handle: '.handle',
                cursor: 'move',
                axis: 'y',
                placeholder: 'social-network-widget-item ui-state-placeholder',
                containment: widget,
                forcePlaceholderSize: true,
                update: function() {
                    SNW._livePreviewUpdate(
                        $( this ).parents( '.form' ).find( '.widget-control-save' )
                    );
                },
            } );
        },

        // Initialize color picker
        _initColorPicker: function( widget ) {
            widget.find( SNW.vars.colorpicker ).wpColorPicker( {
                change: _.throttle( function() { // For Customizer
                    $( this ).trigger( 'change' );
                }, 3000 )
            } );
        },

        _livePreviewUpdate: function( button ) {
            if ( ! $( document.body ).hasClass( 'wp-customizer' ) || ! button.length ) {
                return;
            } // End If Statement

            button.trigger( 'click' ).hide();
        }

    };

    $( document ).ready( SNW.ready() );
    
} )( window.wp, jQuery );