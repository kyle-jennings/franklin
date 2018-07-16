const { __ } = wp.i18n;
const { RichText, MediaUpload, PlainText, BlockControls, InspectorControls } = wp.editor;
const { registerBlockType } = wp.blocks;
const { DropdownMenu, Dropdown, TextareaControl } = wp.components;

registerBlockType('franklin/alertpanel', {
	title: 'USA Alert2',
	keywords: ['alert', 'notice', 'notification'],
	icon: 'info',
	category: 'layout',
	attributes: {
		title: {
			source: 'text',
			selector: '.usa-alert-heading'
		},

		text: {
			source: 'text',
			selector: '.usa-alert-text'
		},

		color: {},
	},

	edit({attributes, className, setAttributes, focus}) {
		const colorArray = [
			{
				title: 'Success',
				onClick: () => changeAlertColor( 'success' )
			},
			{
				title: 'Warning',
				onClick: () => changeAlertColor( 'warning' )
			},
			{
				title: 'Error',
				onClick: () => changeAlertColor( 'error' )
			},
			{
				title: 'Info',
				onClick: () => changeAlertColor( 'info' )
			}
		];

		const changeAlertColor = (color) => {
			color = 'usa-alert-' + color;
			setAttributes({ color: color});
		}

		return (
			<div class="guttenberg-usa-alert">
			<InspectorControls>
				<h3>Boom</h3>
			</InspectorControls>
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
				<div className={'usa-alert ' + attributes.color}>
					<div class="usa-alert-body">
						<h3 class="usa-alert-heading">
							<PlainText
							  onChange={ content => setAttributes({ title: content }) }
							  value={ attributes.title }
							  placeholder="Your alert title"
							  className="button-title"
							/>
						</h3>
						<p class="usa-alert-text">
							<TextareaControl
							  onChange={ content => setAttributes({ text: content }) }
							  value={ attributes.text }
							  placeholder="Your alert text"
							  className="alert-text"
							/>
						</p>
					</div>
				</div>
			</div>
		);
	},
	
	save({attributes}) {
		return (
			<div className={'usa-alert ' + attributes.color }>
				<div class="usa-alert-body">
					<h3 class="usa-alert-heading">{attributes.title}</h3>
					<p class="usa-alert-text">{attributes.text}</p>
				</div>
			</div>
		);
	} 

});