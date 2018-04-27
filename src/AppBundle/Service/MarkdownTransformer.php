<?php

namespace AppBundle\Service;

use Doctrine\Common\Cache\Cache;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownTransformer
{
    /**
     * @var MarkdownParserInterface
     */
    private $markdownParser;
    /**
     * @var Cache
     */
    private $cache;

    public function __construct(MarkdownParserInterface $markdownParser, Cache $cache)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
    }

    public function parse(string $str): string
    {
        $key   = md5($str);
        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        sleep(1);
        $str = $this->markdownParser->transformMarkdown($str);
        $this->cache->save($key, $str);

        return $str;
    }
}