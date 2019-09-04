<?php

namespace App\Controller;

use App\Entity\CommonWord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\XMLParser;
use App\Service\TextAnalyzer;

class IndexController extends AbstractController
{
    /**
     * @param XMLParser $parser
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(XMLParser $parser, TextAnalyzer $analyzer)
    {
        $data = [];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Get array of RSS entries
            $data = $parser->parse();

            // Get text to analyze, extracting only title and summary from RSS feed
            $text_to_analyze = '';
            array_walk($data['entry'], function($item) use (&$text_to_analyze){
//                $text_to_analyze .= str_replace( '…', '', strip_tags(trim($item['title'])) . ' '.strip_tags(trim($item['summary'])) . ' ');
                $text_to_analyze .= trim($item['title']) . ' ' . trim($item['summary']) . ' ';
            });


            // Get words to exclude. Words to exclude are stored in database (in the future they could be editable)
            $cw_repository = $this->getDoctrine()->getRepository(CommonWord::class);
            $common_words = $cw_repository->getWordsSortedByRank(50);

            // get array of words with their number in text
            $data['words_count'] = $analyzer->createAnalyzer($text_to_analyze)
                                            ->wordsExclude($common_words)
                                            ->wordsCount()
                                            ->getWordsCount(10);

        }

        return $this->render('index/index.html.twig', ['data' => $data]);
    }

}
