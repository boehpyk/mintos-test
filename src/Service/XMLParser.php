<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 01/09/2019
 * Time: 16:44
 */

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class XMLParser
{
    /**
     * Parameters defined in config/services.yaml
     * @var ParameterBagInterface
     */
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    /**
     * Function returns array of data retrieved from XML source
     * @return array
     */
    public function parse(): array
    {
        $result = [];

        try {
            $xml = simplexml_load_file($this->params->get('rss_feed'), 'SimpleXMLElement', LIBXML_NOWARNING);
            if ($xml) {
                $result = json_decode(json_encode($xml), true);
            } else {
//            throw new Exception("Cannot load xml source.\n");
            }
        }
        catch (\Exception $err) {
            dump($err->getMessage());
        }

        return $result;
    }
}