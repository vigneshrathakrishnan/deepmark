( function( blocks, element, editor, components, apiFetch ) {
    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { InspectorControls } = editor;
    const { PanelBody, SelectControl } = components;
    
    let formOptions = [];

    // Fetch VForm list via REST API
    apiFetch({ path: '/vform/v1/forms' }).then(forms => {
        formOptions = forms.map(form => ({
            label: form.formname,
            value: form.id
        }));
    });

    registerBlockType('vform/block', {
        title: 'VForm',
        icon: 'forms',
        category: 'widgets',
        attributes: {
            form_id: { type: 'string', default: '' },
            form_preview: { type: 'string', default: '' }
        },

        edit: function(props) {
            const { attributes, setAttributes } = props;

            // Fetch form preview when form_id changes
            function fetchPreview(formID) {
                if (!formID) return;
                apiFetch({ path: `/vform/v1/form-preview/${formID}` }).then(preview => {
                    setAttributes({ form_id: formID, form_preview: preview });
                });
            }

            return [
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Form Settings' },
                        el(SelectControl, {
                            label: 'Select Form',
                            value: attributes.form_id,
                            options: [{ label: 'Select a Form', value: '' }].concat(formOptions),
                            onChange: fetchPreview
                        })
                    )
                ),
                attributes.form_preview
                    ? el('div', { dangerouslySetInnerHTML: { __html: attributes.form_preview } })
                    : el('p', {}, 'Select a form to preview')
            ];
        },

        save: function() {
            return null;
        }
    });
} )( window.wp.blocks, window.wp.element, window.wp.editor, window.wp.components, window.wp.apiFetch );
