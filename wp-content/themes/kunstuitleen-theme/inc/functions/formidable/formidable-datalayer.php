<?php

class formidableDatalayer  {

    function __construct() {
        //add_action('frm_additional_form_options', [$this, 'options']);
        add_filter('frm_add_form_settings_section', [$this, 'settings'], 10, 2);
        add_filter('frm_form_options_before_update', [$this, 'saveSettings'], 20, 2);
    }

    public function settings($sections, $values)
    {

        $sections[] = array(
            'name'		=> 'Datalayer',
            'anchor'	=> 'datalayer',
            'function'	=> 'options',
            'class'	=> $this
        );
        return $sections;
    }

    public function options($values) {
        $form_fields = FrmField::getAll('fi.form_id='. (int) $values['id'] ." and fi.type not in ('break', 'divider', 'html', 'captcha', 'form')", 'field_order');
        $my_form_opts = maybe_unserialize(get_option('frm_datalayer_' . $values['id']));

        ?>

        <table class="form-table datalayer-fields">
            <tr>
                <td width="100px">
                    <label for="event">Event</label>
                </td>
                <td>

                    <select id="event" name="frm_datalayer[event]">
                        <?php foreach([
                                'none'                => 'Geen Datalayer',
                                'enhancedConversions' => 'Enhanced Conversions',
                                'purchase'            => 'Purchase'
                            ] as $event => $label
                        ) {
                            $selected = ( isset( $my_form_opts['event'] ) && $my_form_opts['event'] == $event ) ? ' selected="selected"' : ''; ?>
                            <option value="<?= $event ?>"<?= $selected ?>><?= $label ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr class="conditional-field" data-condition-field="event" data-condition-value="enhancedConversions,purchase">
                <td colspan="2"><h3>Velden</h3></td>
            </tr>
            <?php
            // Keys are in Dutch, this makes it easier to push to the datalayer (which requires Dutch names) Zendesk#9683
            foreach([
                  'email'          => ['label' => 'E-mail *', 'required' => true, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'voornaam'       => ['label' => 'Voornaam', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'achternaam'     => ['label' => 'Achternaam', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'land'           => ['label' => 'Land', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'postcode'       => ['label' => 'Postcode', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'straat'         => ['label' => 'Straat', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'woonplaats'     => ['label' => 'Woonplaats', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'telefoonnummer' => ['label' => 'Telefoonnummer', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'enhancedConversions,purchase'],
                  'price'          => ['label' => 'Purchase: Bedrag', 'heading' => 'Event: Purchase', 'required' => false, 'condition_field' => 'event', 'condition_value' => 'purchase'],
                ] as $key => $args
            ) { ?>
            <?php if(isset($args['heading'])){ ?>
                <tr class="conditional-field" data-condition-field="event" data-condition-value="purchase">
                    <td colspan="2"><h3><?= $args['heading'] ?></h3></td>
                </tr>
            <?php } ?>
            <tr<?php if(isset($args['condition_field'])){ ?> class="conditional-field" data-condition-field="<?= $args['condition_field'] ?>" data-condition-value="<?= $args['condition_value'] ?>"<?php } else { echo ' data-none="true"'; }?>>
                <td width="100px">
                    <label for="<?= $key ?>"><?= $args['label'] ?></label>
                </td>
                <td>
                    <select id="<?= $key ?>" name="frm_datalayer[<?= $key ?>]"<?= $args['required'] ? ' required' : '' ?>>
                        <option value=""><?php _e( '— Select —' ); ?></option>
                        <?php foreach ( $form_fields as $form_field ) {
                            $selected = ( isset( $my_form_opts[$key] ) && $my_form_opts[$key] == $form_field->id ) ? ' selected="selected"' : '';
                            ?>
                            <option value="<?php echo $form_field->id ?>" <?php echo $selected ?>><?php echo FrmAppHelper::truncate( $form_field->name, 40 ) ?></option>
                        <?php } ?>
                    </select>
                    <?php if(isset($args['description'])){ ?>
                        <p><em><?= $args['description'] ?></em></p>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <script type="text/javascript">


            let datalayerFields = document.querySelectorAll('.datalayer-fields select');
            if(datalayerFields) {
                datalayerFields.forEach((field) => {
                    field.addEventListener('change', (e) => {
                        let id = e.currentTarget.id;
                        let value = e.currentTarget.value;
                        let conditionalFields = document.querySelectorAll('tr.conditional-field[data-condition-field*="' + id + '"]');
                        if(conditionalFields) {
                            conditionalFields.forEach((conditionalField) => {
                                if (conditionalField.dataset.conditionValue.includes(value)) {
                                    conditionalField.style.display = 'table-row';
                                } else {
                                    conditionalField.style.display = 'none';
                                }
                            })
                        }
                    })
                })
            }

            // Trigger on load
            let fieldEvent = document.querySelector('.datalayer-fields select#event');
            if(fieldEvent) {
                fieldEvent.dispatchEvent(new Event('change'));
            }


            // jQuery(document).ready(function($) {
            //     // Example: Toggle 'my_custom_field' based on a checkbox value
            //     function toggleMyCustomField() {
            //         var isChecked = $('#your_condition_field_id').is(':checked');
            //         if (isChecked) {
            //             $('.my_custom_class').show(); // Adjust selector as needed
            //         } else {
            //             $('.my_custom_class').hide(); // Adjust selector as needed
            //         }
            //     }
            //
            //     // Initial check on page load
            //     toggleMyCustomField();
            //
            //     // Check on change
            //     $('#your_condition_field_id').change(toggleMyCustomField);
            // });
        </script>
        <?php
    }

    public function saveSettings($options, $values) {

        if ( isset( $values['frm_datalayer'] ) ) {
            $new_values = maybe_serialize( $values['frm_datalayer'] );
            update_option( 'frm_datalayer_' . $values['id'], $new_values );
        }

        return $options;
    }
}

$datalayer = new formidableDatalayer();