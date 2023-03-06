/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';

import { TextControl } from '@wordpress/components';
import { useSelect, select } from '@wordpress/data';
import { uploadMedia } from '@wordpress/media-utils';
import { useEntityProp } from '@wordpress/core-data';
import { useState } from '@wordpress/element';


function takeScreenShot (url, callBack, error = () => {console.error('Requête impossible')}) {
	let t_url = 'https://api.screenshotmachine.com/?';
	t_url += 'key='+window.apiKey;
	t_url += '&url='+url;
	t_url += '&dimension=1920x1080&format=png';
	fetch(t_url).then(response => response.blob()).then(callBack).catch(error)
}
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {

	const { setAttributes, attributes } = props;
	const postType = useSelect(
		( select ) => select( 'core/editor' ).getCurrentPostType(),
		[]
	);
	const [is_loading, setLoader] = useState(false);
	const [loading_msg, set_loading_message] = useState('');
	window.addEventListener('screenshotReady', updateMedia)

	async function updateMedia (e) {
		if (window.currentScreenToEdit === e.detail)
			return;
		window.currentScreenToEdit = e.detail;
		e.stopPropagation();
		set_loading_message('Ajout du screenshot en tant que thumbnail...')
		wp.data.dispatch("core/editor").editPost({'featured_media' : window.currentScreenToEdit});
		set_loading_message('Finalisation...')
		wp.data.dispatch("core/editor").savePost();
		setLoader(false);
	}

	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

	const urlValue = meta[ 'site_url' ];
	const updateMetaValue = ( newValue ) => {
			setMeta( { ...meta, site_url: newValue } );
	};
	return (
			<p { ...useBlockProps() }>
					<TextControl
							placeholder="saisissez l'url du site"
							label="Url du site"
							value={ urlValue }
							onChange={ updateMetaValue }
					/>
					{
						is_loading ?
							<p>{loading_msg}</p>
						:
						<button onClick={() => {
							set_loading_message('Récupération et enregistrement du screenshot...');
							setLoader(true);
							takeScreenShot(urlValue, (image) => {
								uploadMedia({
									filesList: [ image ],
									onFileChange: ( [ fileObj ] ) => {
										if (fileObj && 'id' in fileObj) {
											let event = new CustomEvent("screenshotReady", {
												detail: fileObj.id,
											});
											window.dispatchEvent(event);
										}
									},
									onError: (msg) => {
										setLoader(false);
										console.error(msg);
										alert('Un problème est survenu lors du screenshot !');
									},
								});
							});
						}}>
							Charger le screen
						</button>
					}
			</p>
	);
}
