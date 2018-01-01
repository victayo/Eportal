<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/EportalSession for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalSession\Controller;

use EportalProperty\Controller\AbstractEportalPropertyController;
use EportalSession\Service\EportalSessionServiceInterface;

class EportalSessionController extends AbstractEportalPropertyController {

    /**
     *
     * @var EportalSessionServiceInterface
     */
    protected $eportalSessionService;

    public function __construct(EportalSessionServiceInterface $eportalSessionService) {
        $this->eportalSessionService = $eportalSessionService;
    }
    
    protected function getProperty($query){
        if (!isset($query['pid'])) {
            return [
                'sessions' => $this->json($this->eportalSessionService->getSession()),
                'success' => true
            ];
        }
        return [
            'terms' => $this->json($this->eportalSessionService->getTerms($query['pid'])),
            'success' => true
        ];
    }

    protected function addChildPost($query, $terms) {
        if (!empty($terms)) {
            foreach (array_keys($terms) as $term) {
                $this->eportalSessionService->addTerm($query['pid'], $term);
            }
        }
        return $this->redirect()->toRoute(self::SESSION_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $query['pid']]]);
    }

    protected function removeChild($query = []) {
        $sessionId = $query['sid'];
        $termId = $query['pid'];
        $this->eportalSessionService->removeTerm($sessionId, $termId);
        $this->redirect()->toRoute(self::SESSION_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $sessionId]]);
    }

    public function getEportalSessionService() {
        return $this->eportalSessionService;
    }

    public function setEportalSessionService(EportalSessionServiceInterface $eportalSessionService) {
        $this->eportalSessionService = $eportalSessionService;
        return $this;
    }

    protected function getBodyPanelVariables($query) {
        $session = $query['pid'];
        $variables = [];
        $variables['title'] = 'terms';
        $variables['add_url'] = $this->url()->fromRoute(self::SESSION_ROUTE, ['action' => 'add-child'], ['query' => ['pid' => $session]]);
        $variables['property_values'] = [];
        $termes = $this->eportalSessionService->getTerms($session);
        foreach ($termes as $term) {
            $variables['property_values'][] = [
                'name' => $term->getValue(),
//                'url' => $this->url()->fromRoute(self::TERM_ROUTE, ['action' => 'manage'], ['query' => ['sid' => $session, 'pid' => $term->getId()]]),
                'url' => '',
                'delete_url' => $this->url()->fromRoute(self::SESSION_ROUTE, ['action' => 'delete-child'], ['query' => ['sid' => $session, 'pid' => $term->getId()]])
            ];
        }
        $data = [];
        $data[] = $variables;
        return [
            'view_data' => $data
        ];
    }

    protected function getPageHeaderVariables($query) {
        $session = $this->eportalSessionService->getSession($query['pid']);
        $breadcrumbs = [
            [
                'name' => $session->getProperty()->getName(),
                'url' => $this->url()->fromRoute(self::SESSION_ROUTE, ['action' => 'manage'])
            ]
        ];
        $variables = [
            'title' => self::EPORTAL_SESSION,
            'breadcrumbs' => $breadcrumbs,
            'active' => $session->getValue()
        ];
        return $variables;
    }

    protected function getAddHeaderVariables($query) {
        $session = $this->eportalSessionService->getSession($query['pid']);
        $breadcrumbs = [
            [
                'name' => $session->getProperty()->getName(),
                'url' => $this->url()->fromRoute(self::SESSION_ROUTE, ['action' => 'manage'])
            ],
            [
                'name' => $session->getValue(),
                'url' => $this->url()->fromRoute(self::SESSION_ROUTE, ['action' => 'manage'], ['query' => ['pid' => $session->getId()]])
            ]
        ];
        $variables = [
            'title' => 'Add Terms',
            'breadcrumbs' => $breadcrumbs,
            'back_url' => $this->url()->fromRoute(self::SESSION_ROUTE, ['action' => 'manage'])
        ];
        return $variables;
    }

    public function getAddBodyVariables($query) {
        $termes = $this->eportalSessionService->getUnmappedTerms($query['pid']);
        return [
            'property_values' => $termes,
            'property' => self::EPORTAL_TERM,
            'title' => 'terms'
        ];
    }

}
