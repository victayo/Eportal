<?php

namespace Result\Mapper;

/**
 *
 * @author imaleo
 *        
 */
class ResultMapper extends AbstractResultDbMapper implements ResultMapperInterface {

    protected $tableName = 'result';

    /*
     * @see \Result\Mapper\ResultMapperInterface::findById()
     */

    public function findById($result_id) {
        $select = $this->getSelect()->where(array(
            'id = ?' => $result_id
        ));
        return $this->select($select)->current();
    }

    /*
     * @see \Result\Mapper\ResultMapperInterface::getResult()
     */

    public function getResult($user, $session, $term, $subject = null) {
        $where = array(
            'user = ?' => $user,
            'session = ?' => $session,
            'term = ?' => $term
        );
        if ($subject) {
            $where['subject'] = $subject;
        }
        $select = $this->getSelect()->where($where);
        if (!$subject || is_array($subject)) { //for a collection of subjects....
            return $this->select($select);
        }
        return $this->select($select)->current();
    }

    public function getSubjects($user, $session, $term) {
        $where = array(
            'user = ?' => $user,
            'session = ?' => $session,
            'term = ?' => $term
        );
        $select = $this->getSelect()
                ->columns(array('subject'))
                ->where($where);
        $results = $this->select($select);
        $subjects = [];
        foreach ($results as $result) {
            $subjects[] = $result->getSubject();
        }
        return $subjects;
    }

    public function getTerm($user, $subject, $session) {
        $where = array(
            'user = ?' => $user,
            'session = ?' => $session,
            'subject = ?' => $subject
        );
        $select = $this->getSelect()
                ->columns(array('term'))
                ->where($where);
        $results = $this->select($select);
        $terms = [];
        foreach ($results as $result) {
            $terms[] = $result->getTerm();
        }
        return $terms;
    }

    public function getUsers($session, $term, $subject) {
        $where = array(
            'subject = ?' => $subject,
            'session = ?' => $session,
            'term = ?' => $term
        );
        $select = $this->getSelect()
                ->columns(array('user'))
                ->where($where);
        $results = $this->select($select);
        $users = [];
        foreach ($results as $result) {
            $users[] = $result->getUser();
        }
        return $users;
    }

}
