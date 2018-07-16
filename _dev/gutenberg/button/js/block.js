const { __ } = wp.i18n;
const { RichText, MediaUpload, PlainText, BlockControls, UrlInput, } = wp.editor;
const { registerBlockType } = wp.blocks;
const { Dashicon, DropdownMenu, Dropdown, Button, IconButton, } = wp.components;

registerBlockType('franklin/button', {
	title: 'USA Button',
	keywords: ['button' ],
	icon: 'button',
	category: 'layout',
	attributes: {
		text: {
			source: 'text',
			selector: '.usa-button'
		},

		url: {
			type: 'string',
			source: 'attribute',
			selector: 'a',
			attribute: 'href',
		},

		color: {},
	},

	edit({attributes, className, setAttributes, focus}) {
		const colorArray = [
			{
				title: 'Primary',
				onClick: () => changeButtonColor( 'primary' )
			},
			{
				title: 'Primary Alt',
				onClick: () => changeButtonColor( 'primary-alt' )
			},
			{
				title: 'Secondary',
				onClick: () => changeButtonColor( 'secondary' )
			},
			{
				title: 'Gray',
				onClick: () => changeButtonColor( 'gray' )
			},
			{
				title: 'Outlined',
				onClick: () => changeButtonColor( 'outline' )
			},
		];

		const changeButtonColor = (color) => {
			color = 'usa-button-' + color;
			setAttributes({ color: color});
		}

		return (
			<div class="guttenberg-usa-button">
				{
					! focus && (
						<BlockControls>
							<DropdownMenu
								icon="art"
								label="Choose a color"
								controls={ colorArray }
							/>
						</BlockControls>
					)
				}
				<a className={'usa-button ' + attributes.color } >
					<PlainText
					  onChange={ content => setAttributes({ text: content }) }
					  value={ attributes.text }
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
		);
	},
	
	save({attributes}) {
		return (
			<a href={attributes.url} className={'usa-button ' + attributes.color }>
				{ attributes.text }
			</a>
		);
	} 

});