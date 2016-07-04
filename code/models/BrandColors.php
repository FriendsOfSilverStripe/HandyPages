<?php

/**
 * Just a holder for a brand color defined by the administrator. Usually done in the SiteConfig, see extension.
 *
 * @author Peter Thaleikis
 */

class BrandColors extends SubsiteSafeDataObject
{
    /**
     * @var array
     */
    private static $db = [
        'ColorName' => 'varchar(50)',
        'ColorCode' => 'varchar(50)',
        'CSSClass' => 'varchar(50)',
        'SubsiteID' => 'int',
        'Sort' => 'int',
        'BrandColor' => 'varchar(50)',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'ColorName' => 'Color name',
        'ColorCode' => 'Color code',
        'CSSClass' => 'CSS class',
    ];

    /**
     * saves the actual value we want to use in the db. no live calculated because it will be static anyway.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $this->BrandColor = (strlen($this->CSSClass) == 0) ? $this->ColorCode : $this->CSSClass;
    }

    /**
     * make the form a bit more usable.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // "disclaimer"
        $fields->addFieldToTab(
            'Root.Main',
            WarningMessage::create('Warning: Please be careful with the following settings. Any changes can decrease the accessibility or violate the branding guide lines.'),
            'ColorName'
        );

        // give the option to actually select a color.
        $fields->replaceField(
            'ColorCode',
            ColourPicker::create('ColorCode', 'Color code')
                ->setRightTitle('Please ensure the color is exactly the intended value.')
        );

        // add some words around this to make it more usable.
        $fields->dataFieldByName('CSSClass')
            ->setTitle('CSS class')
            ->setRightTitle('This CSS class will be return <b>instead</b> of the color code, if defined.');
        $fields->dataFieldByName('ColorName')
            ->setTitle('Color name')
            ->setRightTitle('This name will be displayed throughout the administration interface.');

        // hide some fields like the subsiteid (only if subsite module) is installed.
        $fields->replaceField('BrandColor', HiddenField::create('BrandColor', 'BrandColor', $this->BrandColor));
        if (class_exists('Subsite')) {
            $fields->replaceField(
                'SubsiteID',
                HiddenField::create('SubsiteID', 'Subsite', Subsite::currentSubsite())
            );
        }

        // no one cares about the sort order
        $fields->replaceField('Sort', HiddenField::create('Sort', 'Sort', $this->Sort));

        return $fields;
    }
}
