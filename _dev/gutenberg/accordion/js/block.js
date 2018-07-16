const { __ } = wp.i18n;
const { RichText, MediaUpload, PlainText, BlockControls } = wp.editor;
const { registerBlockType } = wp.blocks;
const { DropdownMenu, Dropdown, TextareaControl } = wp.components;

registerBlockType('franklin/accordion', {
	title: 'USA Accordion',
	keywords: ['accodion', 'collapsible', 'expand'],
	icon: 'editor-expand',
	category: 'layout',
	attributes: {
		title: {
			source: 'text',
			selector: '.usa-accordion-button'
		},

		text: {
			source: 'text',
			selector: '.usa-accordion-content'
		},

		color: {},
	},

	edit({attributes, className, setAttributes, focus}) {


		return (
			<div class="guttenberg-usa-accordion">
				<div class="usa-accordion-bordered">
					<button class="usa-accordion-button" aria-controls="accordion-1" aria-expanded="false">
							<PlainText
							  onChange={ content => setAttributes({ title: content }) }
							  value={ attributes.title }
							  placeholder="Your accordion title"
							  className="accordion-title"
							/>
					</button>
					<div class="usa-accordion-content" id="accordion-1" aria-hidden="false">
						<TextareaControl
						  onChange={ content => setAttributes({ text: content }) }
						  value={ attributes.text }
						  placeholder="Your Accordion text"
						  className="accordion-text"
						/>
					</div>
				</div>
			</div>
		);
	},
	
	save({attributes}) {
		return (
			<div class="usa-accordion-bordered">
				<button class="usa-accordion-button" aria-controls="accordion-1" aria-expanded="false">
					{attributes.title}
				</button>
				<div class="usa-accordion-content" id="accordion-1" aria-hidden="false">
					{attributes.text}
				</div>
			</div>
		);
	} 

});