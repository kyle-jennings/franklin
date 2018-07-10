const { __ } = wp.i18n;
const { RichText, MediaUpload, PlainText } = wp.editor;
const { registerBlockType, BlockControls, AlignmentToolbar } = wp.blocks;
const { DropdownMenu, Dropdown } = wp.components;
const { Button } = wp.components;

BlockControls,
	AlignmentToolbar

registerBlockType('franklin/navlist', {
	title: 'Button',
	keywords: ['nav','menu'],
	icon: 'admin-links',
	category: 'layout',
	attributes: {
		title: {
			source: 'text',
			selector: '.navlist__title'
		},


		color: {},
	},

	edit({attributes, className, setAttributes, focus}) {
		

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

			</div>
		);
	},
	
	save({attributes}) {
		return (
			'[nav-list title="the title" menu="Footer Widget"]'
		);
	} 

});