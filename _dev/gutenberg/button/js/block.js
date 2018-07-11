const { __ } = wp.i18n;
const { RichText, MediaUpload, PlainText, BlockControls } = wp.editor;
const { registerBlockType } = wp.blocks;
const { DropdownMenu, Dropdown, Button } = wp.components;

registerBlockType('franklin/button', {
	title: 'Button',
	keywords: ['button' ],
	icon: 'admin-links',
	category: 'layout',
	attributes: {
		text: {
			source: 'text',
			selector: '.usa-button'
		},

		url: {
			source: 'text',
			selector: '.url'
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
				<button className={'usa-button ' + attributes.color } >
					<PlainText
					  onChange={ content => setAttributes({ text: content }) }
					  value={ attributes.text }
					  placeholder="Your button text"
					  className="button-text"
					/> 
				</button>
			</div>
		);
	},
	
	save({attributes}) {
		return (
			<button className={'usa-button ' + attributes.color }>
				{ attributes.text }
			</button>
		);
	} 

});