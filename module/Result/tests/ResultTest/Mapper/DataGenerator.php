<?php

namespace ResultTest\Mapper;

/**
 * Description of DataGenerator
 *
 * @author imaleo
 */
class DataGenerator {

    private static $loadedResult = [];
    public static $resultInArray = false;
    
    public static function resultScoreData($results = null, $assessments = 3, $min_score = 0, $max_score = 100) {
        if (!$results) {
            $results = self::resultData();
        }
        $resultScores = [];
        foreach ($results as $id => $result) {
            for ($ass = 1; $ass <= $assessments; $ass++) {
                $resultScores[] = array(
                    'result' => $id + 1,
                    'assessment' => $ass,
                    'score' => rand($min_score, $max_score)
                );
            }
        }
        return $resultScores;
    }

//    public static function loadResultScore($resultScoreFilename, $totalResult = 45, $totalAssessments = 3, $min = 0, $max = 100) {
    public static function loadResultScore($resultScoreFilename, $results, $totalAssessments = 3, $min = 0, $max = 100) {
        if (file_exists($resultScoreFilename)) {
            unlink($resultScoreFilename);
        }
        $handle = fopen($resultScoreFilename, 'a+');
        $insert = 'insert into result_score (result, assessment, score) values';
//        for ($r = 1; $r <= $totalResult; $r++) {
//            for ($a = 1; $a <= $totalAssessments; $a++) {
//                $random = rand($min, $max);
//                $ins = $insert . "('{$r}', '{$a}', '{$random}');" . PHP_EOL;
//                fwrite($handle, $ins);
//                $ins = '';
//            }
//        }
        $count = count($results);
        for ($r = 1; $r <= $count; $r++) {
            for ($a = 1; $a <= $totalAssessments; $a++) {
                $random = rand($min, $max);
                $ins = $insert . "('{$r}', '{$a}', '{$random}');" . PHP_EOL;
                fwrite($handle, $ins);
                $ins = '';
            }
        }
        fclose($handle);
    }

    public static function loadResult($resultFilename, $subjects, $sessions, $terms, $totalUsers = 5) {
        if (file_exists($resultFilename)) {
            unlink($resultFilename);
        }
        self::$loadedResult = [];
        $handle = fopen($resultFilename, 'a+');
        $insert = 'insert into result (user, subject, session, term) values';
        for ($user = 1; $user <= $totalUsers; $user++) {
            foreach ($sessions as $session) {
                foreach ($terms as $term) {
                    foreach ($subjects as $subject) {
                        $ins = $insert . "('{$user}', '{$subject}', '{$session}', '{$term}');" . PHP_EOL;
                        fwrite($handle, $ins);
                        $ins = '';
                        if (self::$resultInArray) {
                            self::$loadedResult[] = array(
                                'user' => $user,
                                'session' => $session,
                                'term' => $term,
                                'subject' => $subject
                            );
                        }
                    }
                }
            }
        }
        fclose($handle);
    }

    public static function getLoadedResult() {
        return self::$loadedResult;
    }
    
}

//$resultFilename = "C:/xampp/htdocs/Eportal/module/Result/tests/ResultTest/_file/result.sql";
//$resultScorefilename = "C:/xampp/htdocs/Eportal/module/Result/tests/ResultTest/_file/resultscore.sql";
//DataGenerator::loadResultScore($resultScorefilename);
//$subjects = array(24, 25, 28, 29, 30);
//$sessions = array(40);
//$terms = array(44, 45, 46);

//$subjects = array('english', 'maths', 'physics', 'chemistry', 'biology');
//$sessions = array('2012/2013', '2013/2014', '2014/2015');
//$terms = array('first', 'second', 'third');
//DataGenerator::loadResult($resultFilename, $subjects, $sessions, $terms,10);
