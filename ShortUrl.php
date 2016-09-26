<?php
namespace ShortUrls;

class ShortUrl
{

    public static function shorturl(&$parser, &$cache, &$magicWordId, &$ret)
    {
        global $wgTitle, $wgRequest, $wgServer;
        $curNamespace = $wgTitle->getNamespace();
        if ($curNamespace == 5000) {
            $curTitle = $wgTitle->getFullText();
            $params = new \DerivativeRequest(
                $wgRequest,
                [
                    'action'  => 'query',
                    'list' => 'allpages',
                    'apfilterredir' => 'nonredirects',
                    'aplimit' => 500,
                    'apnamespace' => $curNamespace
                ]
            );
            $api = new \ApiMain($params);
            $api->execute();
            $results = $api->getResult()->getResultData();
            $ids = [];
            foreach ($results['query']['allpages'] as $key => $page) {
                $ids[$key] = $page['pageid'];
            }
            array_multisort($ids, SORT_ASC, $results['query']['allpages']);
            foreach ($results['query']['allpages'] as $num => $page) {
                if ($page['title'] == $curTitle) {
                    $curNum = $num;
                    break;
                }
            }
            $ret = $wgServer.'/'.$curNum;
        }
        return true;
    }

    public static function declareIds(&$customVariableIds)
    {
        $customVariableIds[] = 'shorturl';
        return true;
    }
}
