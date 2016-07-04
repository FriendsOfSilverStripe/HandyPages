<?php

/**
 * The core of HandyPages is this generic page - contains all logic and smarts.
 *
 * @author Peter Thaleikis
 */

class GenericPage extends Page
{
    /**
     * @var array
     */
    private static $db = [
        'AlternativeTitle' => 'varchar(50)',
        'Intro' => 'varchar(1000)',
        'Color' => 'varchar(50)',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Image' => 'Image',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $hiddenFields = $this->config()->get('hideCMSInputs');

        // short title?
        if (!in_array('AlternativeTitle', $hiddenFields)) {
            $fields->addFieldToTab(
                'Root.Main',
                TextField::create('AlternativeTitle', 'Alternative Title'),
                'URLSegment'
            );
        }

        // do we want an intro?
        if (!in_array('Intro', $hiddenFields)) {
            $fields->addFieldToTab(
                'Root.Main',
                TextareaField::create('Intro', 'Intro'),
                'Content'
            );
        }

        // add an image
        if (!in_array('Image', $hiddenFields)) {
            $fields->addFieldToTab(
                'Root.Main',
                UploadField::create('ImageID', 'Image')
                    ->setAllowedFileCategories('image')
                    ->setAllowedMaxFileNumber(1),
                'Content'
            );
        }

        // do we use a section color?
        if (!in_array('Color', $hiddenFields)) {
            // default is this brand color.
            $field = NoticeMessage::create('The brand colors have not been defined yet.');

            // usually we replace this with the color palette.
            if (BrandColors::get()->count() > 0) {
                $field = ColorPaletteField::create(
                    'Color',
                    'Color',
                    BrandColors::get()->map('BrandColor', 'ColorName')
                )->setRightTitle('Please select a brand color.');
            }

            $fields->addFieldToTab('Root.Main', $field, 'Content');
        }

        // It will repalce Content area field to notice message field, or nothing at the end.
        if ($this->config()->get('useBlocksModule')) {
            // move the block related fields over
            $fields->addFieldsToTab('Root.Main', $fields->findOrMakeTab('Root.Blocks')->Fields(), 'Content');

            // now we really don't need the content field anymore.
            $fields->removeByName('Content');

            // remove the blocks tab
            $fields->removeByName('Root.Blocks');
        }
        if ($this->config()->get('hideContentField')) {
            $fields->removebyName('Content');
        }

        return $fields;
    }

    /**
     * @return ZenValidator
     */
    public function getCMSValidator()
    {
        // create any validation contrain we need
        $validator = ZenValidator::create();

        foreach ($this->config()->get('validation') as $field => $validation) {
            // protection against misconfiguration: is this field actually shown? no? okay, don't validate.
            if (in_array($field, $this->config()->hideCMSInputs)) {
                // just required?
                if (array_key_exists('required', $validation)) {
                    $validator->setConstraint(
                        $field,
                        Constraint_require::create()->setMessage('This field is required.')
                    );
                }

                // min length?
                if (array_key_exists('minLength', $validation)) {
                    $validator->setConstraint(
                        $field,
                        Constraint_length::create('min', $validation['minLength'])
                            ->setMessage(sprintf('Please enter at least %d characters.', $validation['minLength']))
                    );
                }

                // max length?
                if (array_key_exists('maxLength', $validation)) {
                    $validator->setConstraint(
                        $field,
                        Constraint_length::create('max', $validation['maxLength'])
                            ->setMessage(sprintf('Please enter maximal %d characters.', $validation['maxLength']))
                    );
                }

                // width?
                if (array_key_exists('width', $validation)) {
                    $validator->setConstraint(
                        $field,
                        Constraint_dimension::create('width', $validation['width'])
                            ->setMessage(sprintf(
                                'Please upload an image with an width of %s pixel.',
                                $validation['width']
                            )
                        )
                    );
                }

                // height?
                if (array_key_exists('height', $validation)) {
                    $validator->setConstraint(
                        $field,
                        Constraint_dimension::create('height', $validation['height'])
                            ->setMessage(sprintf(
                                'Please upload an image with an height of %s pixel.',
                                $validation['height']
                            )
                        )
                    );
                }
            }
        }

        $this->extend('updateCMSValidator', $validator);

        return $validator;
    }
}

class GenericPage_Controller extends Page_Controller
{
}
