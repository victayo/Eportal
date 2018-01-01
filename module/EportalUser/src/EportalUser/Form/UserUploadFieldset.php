<?php

namespace EportalUser\Form;

use EportalProperty\Form\EportalPropertyFieldset;
use EportalUser\Form\Model\UserUpload;
use Zend\Form\Element\File;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class UserUploadFieldset extends EportalPropertyFieldset {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setObject(new UserUpload())
                ->setHydrator(new ClassMethods());
        $file = new File('users');
        $file->setLabel('Choose User File')
                ->setAttribute('required', 'required');
        $this->add($file);
    }

    public function getInputFilterSpecification() {
        $filter = parent::getInputFilterSpecification();
        $filter['users'] = array(
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\File\MimeType',
                    'options' => array(
                        'enableHeaderCheck' => true,
                        'mimeType' => array(
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        )
                    )
                ),
//                array(
//                    'name' => 'Zend\Validator\File\UploadFile',
//                )
            ),
            'filters' => array(
                array(
                    'name' => 'Zend\Filter\File\RenameUpload',
                    'options' => array(
                        'target' => '.\data\uploads',
                        'randomize' => true,
                        'use_upload_extension' => true
                    )
                )
            )
        );
        return $filter;
        /**
         * @todo add extension validation
         */
    }

}
