<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalDepartment\Controller;

use EportalDepartment\Service\EportalDepartmentServiceInterface;
use EportalProperty\Controller\AbstractEportalPropertyController;

class EportalDepartmentController extends AbstractEportalPropertyController {

    /**
     *
     * @var EportalDepartmentServiceInterface
     */
    protected $eportalDepartmentService;

    public function __construct(EportalDepartmentServiceInterface $eportalDepartmentService) {
        $this->eportalDepartmentService = $eportalDepartmentService;
    }

    protected function getProperty($query){
        if(count($query) > 1){
            return [
                'subjects' => $this->json($this->eportalDepartmentService->getSubject($query['sid'], $query['cid'], $query['pid'])),
                'success' => true
            ];
        }
        return [
            'departments' => $this->json($this->eportalDepartmentService->getDepartment()),
            'success' => true
        ];
    }
    
    protected function removeChild($query) {
       $this->eportalDepartmentService->removeSubject($query['sid'], $query['cid'], $query['did'], $query['pid']);
       return $this->redirect()
                        ->toRoute(self::DEPARTMENT_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $query['sid'], 'cid' => $query['cid'], 'pid'=>$query['did']]]);
    }

    protected function addChildPost($query, $subjects) {
        $schoolId = $query['sid'];
        $classId = $query['cid'];
        $departmentId = $query['pid'];
        if (empty($subjects)) {
            return $this->redirect()->toRoute(self::DEPARTMENT_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $schoolId, 'cid' => $classId, 'pid' => $departmentId]]);
        }
        foreach (array_keys($subjects) as $subject) {
            $this->eportalDepartmentService->addSubject($schoolId, $classId, $departmentId, $subject);
        }
        return $this->redirect()->toRoute(self::DEPARTMENT_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $schoolId, 'cid' => $classId, 'pid' => $departmentId]]);
    }

    protected function getPageHeaderVariables($query) {
        $propertyValueService = $this->PropertyValue();
        $school = $propertyValueService->findById($query['sid']);
        $class = $propertyValueService->findById($query['cid']);
        $department = $this->eportalDepartmentService->getDepartment($query['pid']);
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
            'active' => $department->getValue(),
            'title' => $class->getValue()
        ];
        return $variables;
    }

    protected function getBodyPanelVariables($query) {
        $school = $query['sid'];
        $class = $query['cid'];
        $department = $query['pid'];
        $variables = [];
        $variables['title'] = 'subjects';
        $variables['add_url'] = $this->url()->fromRoute(self::DEPARTMENT_ROUTE, ['action' => 'add-child'], ['query' => ['sid' => $school, 'cid' => $class, 'pid' => $department]]);
        $variables['property_values'] = [];
        $subjects = $this->eportalDepartmentService->getSubject($school, $class, $department);
        foreach ($subjects as $subject) {
            $variables['property_values'][] = [
                'name' => $subject->getValue(),
                'url' => $this->url()->fromRoute(self::SUBJECT_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $school, 'cid' => $class, 'did' => $department, 'pid' => $subject->getId()]]),
                'delete_url' => $this->url()->fromRoute(self::DEPARTMENT_ROUTE, ['action' => 'delete-child'], ['query' => ['sid' => $school, 'cid' => $class, 'did' => $department, 'pid' => $subject->getId()]])
            ];
        }
        $data = [];
        $data[] = $variables;
        return [
            'view_data' => $data
        ];
    }

    protected function getAddBodyVariables($query) {
        $school = $query['sid'];
        $class = $query['cid'];
        $department = $query['pid'];
        $subjects = $this->eportalDepartmentService->getUnaddedSubject($school, $class, $department);
        return [
            'property_values' => $subjects,
            'property' => self::EPORTAL_SUBJECT,
            'title' => 'subjects'
        ];
    }

    protected function getAddHeaderVariables($query) {
        $propertyValueService = $this->PropertyValue();
        $school = $propertyValueService->findById($query['sid']);
        $class = $propertyValueService->findById($query['cid']);
        $department = $this->eportalDepartmentService->getDepartment($query['pid']);
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
            ],
            [
                'name' => $department->getValue(),
                'url' => $this->url()->fromRoute(self::DEPARTMENT_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $school->getId(), 'cid' => $class->getId(), 'pid' => $department->getId()]])
            ]
        ];
        $variables = [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Add Subject',
            'back_url' => $this->url()->fromRoute(self::DEPARTMENT_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $school->getId(), 'cid' => $class->getId(), 'pid' => $department->getId()]])
        ];
        return $variables;
    }

}
