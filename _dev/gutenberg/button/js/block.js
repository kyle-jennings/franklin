const { RichText, MediaUpload, PlainText } = wp.editor;
const { registerBlockType } = wp.blocks;
const { Button } = wp.components;

registerBlockType('franklin/button', {
	title: 'Button',
	icon: 'admin-links',
	category: 'common',
	attributes: {
		text: {
			source: 'text',
			selector: '.text'
		},
		url: {
			source: 'url',
			selector: '.url'
		},
		color: {
			source: 'color',
			selector: '.color'
		},
	},

	edit({attributes, className, setAttributes}) {
		return (
			<div class="usa-button usa-button-gray">
				<PlainText
				  onChange={ content => setAttributes({ text: content }) }
				  value={ attributes.text }
				  placeholder="Your button text"
				  className="button-text"
				/> 
				<PlainText
				  onChange={ content => setAttributes({ color: content }) }
				  value={ attributes.color }
				  placeholder="Your button color"
				  className="button-color"
				/> 
				<PlainText
				  onChange={ content => setAttributes({ url: content }) }
				  value={ attributes.url }
				  placeholder="Your button url"
				  className="button-url"
				/> 
			</div>
		);
	},
	
	save({attributes}) {
		const colorClass = (color) => {
			return 'usa-button-' + color;
		}

		const getURL = (url) => {
			return url;
		}

		return (
			<a class="usa-button {colorClass(attributes.color)}" 
			href="{getURL(attributes.url)">
				{ attributes.text }
			</a>
		);
	} 

});