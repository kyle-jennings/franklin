const { __ } = wp.i18n;
const { RichText, MediaUpload, PlainText, BlockControls, InnerBlocks, UrlInput, } = wp.editor;
const { registerBlockType } = wp.blocks;
const {  Dashicon, DropdownMenu, Dropdown, Button, IconButton, TextareaControl } = wp.components;
const ALLOWED_BLOCKS = [ 'franklin/button' ];

registerBlockType('franklin/callout', {
	title: 'USA Callout',
	keywords: ['callou','well','attention'],
	icon: 'screenoptions',
	category: 'layout',
	attributes: {
		title: {
			source: 'text',
			selector: '.usa-hero-callout-alt'
		},

		description: {
			source: 'text',
			selector: '.site-description'
		},

		buttonText: {
			source: 'text',
			selector: '.usa-button'
		},

		url: {
			type: 'string',
			source: 'attribute',
			selector: 'a',
			attribute: 'href',
		},

	},

	edit({attributes, className, setAttributes}) {
		
		
		return (
			<div class="guttenberg-usa-callout">
				<div class="usa-hero-callout usa-section-dark">
					<h2>
						<span class="usa-hero-callout-alt">
							<PlainText
							  onChange={ content => setAttributes({ title: content }) }
							  value={ attributes.title }
							  placeholder="Your callout title"
							  className="callout-title"
							/> 
						</span>
					</h2>
					<p class="site-description">
						<TextareaControl
						  onChange={ content => setAttributes({ description: content }) }
						  value={ attributes.description }
						  placeholder="Your callout description"
						  className="callout-text"
						/> 
					</p>
					<div class="callout-inner">
						<a className={'usa-button ' + attributes.color } >
							<PlainText
							  onChange={ content => setAttributes({ buttonText: content }) }
							  value={ attributes.buttonText }
							  placeholder="Your button text"
							  className="button-text"
							/> 
						</a>
						<form
							className="usa-button__inline-link"
							onSubmit={ ( event ) => event.preventDefault() }>
							<Dashicon icon="admin-links" />
							<UrlInput
								value={ attributes.url }
								onChange={ ( value ) => setAttributes( { url: value } ) }
							/>
							<IconButton icon="editor-break" label={ __( 'Apply' ) } type="submit" />
						</form>
					</div>
				</div>
			</div>
		);
	},
	
	save({attributes}) {
		return (
			<div class="usa-hero-callout usa-section-dark">
				<h2>
					<span class="usa-hero-callout-alt">
						{attributes.title}
					</span>
				</h2>
				<p class="site-description">
					{attributes.description}
				</p>
				{
					attributes.url && (					
				<div class="callout-inner">
					<a class="usa-button" href={attributes.url}>
						{attributes.buttonText}
					</a>
				</div>
				)
				}
			</div>
		);
	} 

});