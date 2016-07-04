<?php

/**
 * simple extension for the site settings to provide an option to adjust the brand colors.
 *
 * @author Peter Thaleikis
 */

class BrandColorExtension extends DataExtension
{
    /**
     * @param FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        // add a gridfield for the management of the files
        $fields->addFieldsToTab(
            'Root.Brand Colors',
            GridField::create(
                'BrandColors',
                'Brand colors',
                BrandColors::get(),
                GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldSortableRows('Sort'))
            )
        );

        return $fields;
    }
}
