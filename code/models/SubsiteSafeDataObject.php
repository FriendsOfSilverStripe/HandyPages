<?php

/**
 * Just little class to make any SilverStripe dataobject subsite-safe.
 *
 * How to use this? Instead of this:
 *
 * ```php
 * class MyDataObject extends DataObject
 * ```
 *
 * simply do this:
 *
 * ```php
 * class MyDataObject extends SubsiteSafeDataObject
 * ```
 *
 * @author Peter Thaleikis
 */

class SubsiteSafeDataObject extends DataObject
{
    /**
     * @var array
     */
    private static $has_one = [
        'Subsite' => 'Subsite',
    ];

    /**
     * make the form a bit more usable.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // remove it and, if needed re-add it as a hidden field
        $fields->removeByName('SubsiteID');
        if (class_exists('Subsite')) {
            $fields->push(new HiddenField('SubsiteID', 'SubsiteID', Subsite::currentSubsiteID()));
        }

        return $fields;
    }
}
