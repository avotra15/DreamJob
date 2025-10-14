<?php
namespace Service;

use App\Service\PageService;
use App\Service\SearchPageService;
use Exception;
use Symfony\Component\Filesystem\Exception\IOException;


class FilesystemService
{
    private PageService $pgSrv;
    private SearchPageService $srchPSrv;
     private static ?string $lastError = null;

    public function __construct(
        PageService $pgSrv,
        SearchPageService $srchPSrv,
    )
    {
        $this->pgSrv = $pgSrv;
        $this->srchPSrv = $srchPSrv;
    }

        public function chgrp(?iterable $files = null, string|int $group, bool $recursive = false): void
    {
        $files = $this->srchPSrv->filesearch();

        $filespath = array_column($files, 'chemin');

        foreach ($filespath as $file) {
            if ($recursive && is_dir($file) && !is_link($file)) {
                $this->chgrp(new \FilesystemIterator($file), $group, true);
            }
            if (is_link($file) && \function_exists('lchgrp')) {
                if (!lchgrp($file, $group)) {
                    throw new Exception("Failed to change group");
                }
            } else {
                 if (!chgrp($file, $group)) {
                    throw new Exception("Failed to change group");
                }
            }
        }
    }

}
?>