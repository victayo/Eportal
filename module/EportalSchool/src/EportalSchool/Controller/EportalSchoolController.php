<?php

namespace EportalSchool\Controller;

use EportalProperty\Controller\AbstractEportalPropertyController;
use EportalSchool\Service\EportalSchoolServiceInterface;

class EportalSchoolController extends AbstractEportalPropertyController {

    /**
     *
     * @var EportalSchoolServiceInterface
     */
    protected $eportalSchoolService;

    public function __construct(EportalSchoolServiceInterface $eportalSchoolService) {
        $this->eportalSchoolService = $eportalSchoolService;
    }

    public function getEportalSchoolService() {
        return $this->eportalSchoolService;
    }

    public function setEportalSchoolService(EportalSchoolServiceInterface $eportalSchoolService) {
        $this->eportalSchoolService = $eportalSchoolService;
        return $this;
    }

    protected function addChildPost($query, $postData) {
        $school_id = $query['pid'];
        $classes = $postData;
        if (empty($classes)) {
            return $this->redirect()->toRoute(self::SCHOOL_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $school_id]]);
        }
        foreach (array_keys($classes) as $class) {
            $this->eportalSchoolService->addClass($school_id, $class);
        }
        return $this->redirect()->toRoute(self::SCHOOL_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $school_id]]);
    }

    protected function removeChild($query) {
        $school_id = $query['pid'];
        $class_id = $query['cid'];
        $this->eportalSchoolService->removeClass($school_id, $class_id);
        $this->redirect()->toRoute(self::SCHOOL_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $school_id]]);
    }

    protected function getProperty($query) {
        if (!isset($query['pid'])) {
            return [
                'schools' => $this->json($this->eportalSchoolService->getSchool()),
                'success' => true
            ];
        }
        return [
            'classes' => $this->json($this->eportalSchoolService->getClasses($query['pid'])),
            'success' => true
        ];
    }

    protected function getBodyPanelVariables($query) {
        $school = $query['pid'];
        $variables = [];
        $variables['title'] = 'classes';
        $variables['add_url'] = $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'add-child'], ['query' => ['pid' => $school]]);
        $variables['property_values'] = [];
        $classes = $this->eportalSchoolService->getClasses($school);
        foreach ($classes as $class) {
            $variables['property_values'][] = [
                'name' => $class->getValue(),
                'url' => $this->url()->fromRoute(self::CLASS_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $school, 'pid' => $class->getId()]]),
                'delete_url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'delete-child'], ['query' => ['pid' => $school, 'cid' => $class->getId()]])
            ];
        }
        $data = [];
        $data[] = $variables;
        return [
            'view_data' => $data
        ];
    }

    protected function getPageHeaderVariables($query) {
        $school = $this->eportalSchoolService->getSchool($query['pid']);
        $breadcrumbs = [
            [
                'name' => $school->getProperty()->getName(),
                'url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'manage'])
            ]
        ];
        $variables = [
            'title' => self::EPORTAL_SCHOOL,
            'breadcrumbs' => $breadcrumbs,
            'active' => $school->getValue()
        ];
        return $variables;
    }

    protected function getAddHeaderVariables($query) {
        $school = $this->eportalSchoolService->getSchool($query['pid']);
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
            'title' => 'Add Classes',
            'breadcrumbs' => $breadcrumbs,
            'back_url' => $this->url()->fromRoute(self::SCHOOL_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $school->getId()]])
        ];
        return $variables;
    }

    public function getAddBodyVariables($query) {
        $classes = $this->eportalSchoolService->getUnmappedClasses($query['pid']);
        return [
            'property_values' => $classes,
            'property' => self::EPORTAL_CLASS,
            'title' => 'classes'
        ];
    }

}
