/**
 * Initialize jQuery colorpicker
 *
 * @since       1.0.0
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
( function ( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	const SNW = {
		cache() {
			SNW.els = {};
			SNW.vars = {};
			SNW.vars.name = 'social-network-widget';
			SNW.vars.id = '[id*="social_network_widget"]';
			SNW.vars.list = `.social-network-icons-widget-list`;
			SNW.vars.color = `.${ SNW.vars.name }-color-picker`;
			SNW.vars.add = `.${ SNW.vars.name }.add-button button`;
			SNW.vars.remove = `.${ SNW.vars.name }-item__remove a`;
			SNW.els.$doc = $( document );
		},
		// Execute callback after the DOM is loaded.
		ready() {
			SNW.cache();
			SNW.onOpen();
			SNW.onAdd();
			SNW.onUpdate();
			SNW.onRemove();
		},
		// Trigger on widget panel is opened.
		onOpen() {
			SNW.els.$doc.on(
				'click',
				`div.widget${ SNW.vars.id } .widget-title, div.widget${ SNW.vars.id } .widget-action`,
				( event ) => {
					const $this = $( event.target );

					if ( !! $this.parents( '#available-widgets' ).length ) {
						return;
					}
					SNW._sortable( $this.parents( `.widget${ SNW.vars.id }` ) );
					SNW._colorPicker( $this.parents( `.widget${ SNW.vars.id }` ) );
				}
			);
		},
		// Add new social network address field.
		onAdd() {
			SNW.els.$doc.on( 'click', SNW.vars.add, ( event ) => {
				event.preventDefault();

				const $this = $( event.target ),
					$widget = $this.parents( `.widget${ SNW.vars.id }` ),
					$template = $( $.trim( $( `#tmpl-${ SNW.vars.name }` ).html() ) ),
					$widgetContent = $this.parents( '.widget-content' ),
					$widgetList = $widgetContent.find( SNW.vars.list ),
					urlId = $widgetList.data( 'url-icon-id' ),
					urlName = $widgetList.data( 'url-icon-name' );

				$template
					.find( `.${ SNW.vars.name }-item__url input` )
					.attr( 'id', urlId )
					.attr( 'name', `${ urlName }[]` );
				$widgetList.append( $template );
				const $widgetLastItem = $widgetContent.find( `.${ SNW.vars.name }-item:last` );
				$widgetLastItem.find( 'input:first' ).trigger( 'focus' );
				SNW._triggerChange( $widget );
			} );
		},
		// Delete existing social network URL field.
		onRemove() {
			SNW.els.$doc.on( 'click', SNW.vars.remove, ( event ) => {
				event.preventDefault();

				const $this = $( event.target ),
					$widget = $this.parents( `.widget${ SNW.vars.id }` ),
					$button = $this.parents( '.form' ).find( '.widget-control-save' );
				$this.parents( `.${ SNW.vars.name }-item` ).remove();
				SNW._triggerChange( $widget );
				SNW._previewUpdate( $button );
			} );
		},
		// Trigger once the widget is being saved/updated.
		onUpdate() {
			SNW.els.$doc.on( 'widget-updated', ( event, $widget ) => {
				if ( $widget.is( SNW.vars.id ) ) {
					event.preventDefault();
					SNW._sortable( $widget );
					SNW._colorPicker( $widget );
				}
			} );
		},
		// Initialize sortable on social network addresses.
		_sortable( $widget ) {
			$widget.find( SNW.vars.list ).sortable( {
				axis: 'y',
				items: `> .${ SNW.vars.name }-item`,
				handle: '.handle',
				cursor: 'grabbing',
				placeholder: `${ SNW.vars.name }-item ui-state-placeholder`,
				containment: $widget,
				forcePlaceholderSize: true,
				start( event, ui ) {
					ui.placeholder.height( ui.item.height() );
				},
				update( event, ui ) {
					SNW._triggerChange( $widget );
					SNW._previewUpdate( $( ui ).parents( '.form' ).find( '.widget-control-save' ) );
				},
			} );
		},
		// Initialize color picker
		_colorPicker( $widget ) {
			$widget.find( SNW.vars.color ).wpColorPicker( {
				change: _.throttle( function () {
					// For Customizer
					$( this ).trigger( 'change' );
				}, 3000 ),
			} );
		},
		// Activate `Save` button with triggering change of state in the title input.
		_triggerChange( $widget ) {
			$widget.find( 'input[name*="[title]"]' ).trigger( 'change' );
		},
		// Update widget while previewing from the Customizer pane.
		_previewUpdate( $button ) {
			if ( ! $( document.body ).hasClass( 'wp-customizer' ) || ! $button.length > 0 ) {
				return;
			}
			$button.trigger( 'click' ).hide();
		},
	};

	$( document ).ready( SNW.ready() );
} )( window.wp, jQuery );
