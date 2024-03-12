<?php

interface IDownload {
    public function download(string $url): string;
}

class SimpleDownloader implements IDownload {
    public function download(string $url): string {
        return file_get_contents($url);
    }
}

class AAA implements IDownload {
    public function download(string $url): string {
        //curl
        return "";
    }
}

class CashSimpleDownloader extends SimpleDownloader {
    protected array $results = [];

    public function download(string $url): string {
//        if (!isset($this->results[$url])) {
//            $this->results[$url] = parent::download($url);
//        }
        return $this->results[$url] ?? $this->results[$url] = parent::download($url);
    }
}

function app(array $urls, SimpleDownloader $downloader) {
    {
        foreach ($urls as $url) {
            $result = $downloader->download($url);
        }
    }
}

//$downloader = new SimpleDownloader();

$downloader= new AAA();

app([
    'https://google.com',
    'https://facebook.com',
    'https://yahoo.com',
    'https://nv.ua',
],
    $downloader);

exit;