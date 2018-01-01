<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalClass\Controller;

use EportalClass\Service\EportalClassServiceInterface;
use EportalProperty\Controller\AbstractEportalPropertyController;

class EportalClassController extends AbstractEportalPropertyController {

    /**
     *
     * @var EportalClassServiceInterface
     */
    protected $eportalClassService;

    public function __construct(EportalClassServiceInterface $eportalClassService) {
        $this->eportalClassService = $eportalClassService;
    }

    protected function getProperty($query){
        if(isset($query['property'])){//return subject or department
            if($query['property'] === self::EPORTAL_DEPARTMENT){
                return [
                    'departments' => $this->json($this->eportalClassService->getDepartments($query['sid'], $query['pid'])),
                    'success' => true
                ];
            }
            return [
                'subjects' => $this->json($this->eportalClassService->getSubjects($query['sid'], $query['pid'])),
                'success' => true
            ];
        }
        //return all classes
        return [
            'classes' => $this->json($this->eportalClassService->getClass()),
            'success' => true
        ];
        //get sch
    }

    protected function removeChild($query) {
        $property = $query['property'];
        if ($property === self::EPORTAL_DEPARTMENT) {
            $this->eportalClassService->removeDepartment($query['sid'], $query['cid'], $query['pid']);
        }
        if ($property === self::EPORTAL_SUBJECT) {
            $this->eportalClassService->removeSubject($query['sid'], $query['cid'], $query['pid']);
        }
        return $this->redirect()
                        ->toRoute(self::CLASS_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $query['sid'], 'pid' => $query['cid']]]);
    }

    protected function addChildPost($query, $postData) {
        $schoolId = $query['sid'];
        $classId = $query['cid'];
        $propertyValues = $postData;
        if (empty($propertyValues)) {
            return $this->redirect()
                            ->toRoute(self::CLASS_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $schoolId, 'pid' => $classId]]);
        }
        foreach (array_keys($propertyValues) as $propertyValue) {
            if ($query['property'] === self::EPORTAL_SUBJECT) {
                $this->eportalClassService->addSubject($schoolId, $classId, $propertyValue);
            } else {
                $this->eportalClassService->addDepartment($schoolId, $classId, $propertyValue);
            }
        }
        return $this->redirect()
                        ->toRoute(self::CLASS_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $schoolId, 'pid' => $classId]]);
    }

    protected function getPageHeaderVariables($query) {
        $school = $this->PropertyValue()->findById($query['sid']);
        $class = $this->eportalClassService->getClass($query['pid']);
        $breadcrumbs = [
            [
                'name' => $school->getProperty()->getName(),
                'url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'manage'])
            ],
            [
                'name' => $school->getValue(),
                'url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $school->getId()]])
            ]
        ];
        $variables = [
            'breadcrumbs' => $breadcrumbs,
            'active' => $class->getValue(),
            'title' => $school->getValue()
        ];
        return $variables;
    }

    protected function getBodyPanelVariables($query) {
        $allVariables = [];
        $school = $query['sid'];
        $class = $query['pid'];
        $departments = $this->eportalClassService->getDepartments($school, $class);
        $subjects = $this->eportalClassService->getSubjects($school, $class);
        $allVariables[] = $this->getSingleVariable($school, $class, $departments, self::EPORTAL_DEPARTMENT);
        $allVariables[] = $this->getSingleVariable($school, $class, $subjects, self::EPORTAL_SUBJECT);
        return [
            'view_data' => $allVariables
        ];
    }

    protected function getSingleVariable($school, $class, $propertyValues, $propertyName) {
        $variables = [];
        $variables['title'] = $propertyName;
        $variables['add_url'] = $this->url()
                ->fromRoute(self::CLASS_ROUTE, ['action' => 'add-child'], ['query' => ['sid' => $school, 'cid' => $class, 'property' => $propertyName]]);
        $variables['property_values'] = [];
        foreach ($propertyValues as $propertyValue) {
            $var = [
                'name' => $propertyValue->getValue(),
                'delete_url' => $this->url()
                        ->fromRoute(self::CLASS_ROUTE, ['action' => 'delete-child'], ['query' => ['sid' => $school, 'cid' => $class, 'pid' => $propertyValue->getId(), 'property' => $propertyName]])
            ];
            $var['url'] = ($propertyName === 'subject') ? '' : $this->url()
                        ->fromRoute("zfcadmin/eportal-{$propertyName}", ['action' => 'manage'], ['query' => ['sid' => $school, 'cid' => $class, 'pid' => $propertyValue->getId()]]);
            $variables['property_values'][] = $var;
        }

        return $variables;
    }

    protected function getAddBodyVariables($query) {
        $school = $query['sid'];
        $class = $query['cid'];
        $property = $query['property'];
        if ($property === 'subject') {
            $propertyValues = $this->eportalClassService->getUnaddedSubjects($school, $class);
        } else {
            $propertyValues = $this->eportalClassService->getUnaddedDepartment($school, $class);
        }
        return [
            'property_values' => $propertyValues,
            'property' => $property,
            'title' => $property . 's'
        ];
    }

    protected function getAddHeaderVariables($query) {
        $school = $this->PropertyValue()->findById($query['sid']);
        $class = $this->eportalClassService->getClass($query['cid']);
        $property = $query['property'];
        $breadcrumbs = [
            [
                'name' => $school->getProperty()->getName(),
                'url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'manage'])
            ],
            [
                'name' => $school->getValue(),
                'url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $school->getId()]])
            ],
            [
                'name' => $class->getValue(),
                'url' => $this->url()->fromRoute(self::CLASS_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $school->getId(), 'pid' => $class->getId()]])
            ]
        ];
        $variables = [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Add ' . $property,
            'back_url' => $this->url()->fromRoute(self::CLASS_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $school->getId(), 'pid' => $class->getId()]])
        ];
        return $variables;
    }

}
