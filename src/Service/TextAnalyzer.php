<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 01/09/2019
 * Time: 16:44
 */

namespace App\Service;

class TextAnalyzer
{
    private $src;
    private $filtered;
    private $words_count;

    public function __construct()
    {
        $this->src = '';
        $this->result = [];
        $this->words_count = [];
    }

    public function createAnalyzer(string $src)
    {
        if (strlen(strip_tags($src)) > 0) {
            $this->src = strip_tags($src);
//            $this->result = str_word_count($this->src ,1);
            $this->result = $this->splitTextIntoArray($this->src);
        }
        else {
            throw new \UnexpectedValueException('Source string is empty!');
        }
        return $this;
    }

    /**
     * Functions excludes words defined in $to_exclude from $src. Case insensitive.
     * Returns array of remaining words
     * @param array $to_exclude
     * @param null $limit
     * @return self
     */
    public function wordsExclude(array $to_exclude = [], $limit = null):self
    {
        $this->result = array_udiff($this->result, $to_exclude, 'strcasecmp');
        return $this;
    }

    /**
     * Function counts words in result array
     * @return self
     */
    public function wordsCount(): self
    {
        foreach ($this->result as $key => $value)
        {
            if (array_key_exists($value, $this->words_count)) {
                $this->words_count[$value] += 1;
            }
            else {
                $this->words_count[$value] = 1;
            }
        }
        return $this;
    }

    /**
     * Function return src string given in createAnalyzer function
     * @return string
     */
    public function getSrc():string
    {
        return $this->src;
    }

    /**
     * Returns filtered array of words
     * @param integer $limit
     * @return array
     */
    public function getResult($limit = null):array
    {
        return (null === $limit) ? $this->result : array_slice($this->result, 0, $limit);
    }

    /**
     * returns information about how many times each word occurs in an array
     * @param integer $limit
     * @return array
     */
    public function getWordsCount($limit = null):array
    {
        arsort($this->words_count);
        return (null === $limit) ? $this->words_count : array_slice($this->words_count, 0, $limit);
    }

    /**
     * Function splits UTF-8 multibyte string into words and removes one-letter words
     * @param string $subject
     * @return array
     */
    private function splitTextIntoArray($subject):array {
        $one_letter_words = ['a', 'I'];
        preg_match_all('/[\p{L}\p{M}]+/u', $subject, $result, PREG_PATTERN_ORDER);
        return array_filter($result[0], function($item) use ($one_letter_words) {
            return (strlen($item) > 1 or in_array($item, $one_letter_words));
        });
    }
}