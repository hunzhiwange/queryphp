<?php

declare(strict_types=1);

namespace App\Domain\Service\Attachment;

use App\Exceptions\UploadBusinessException;
use App\Exceptions\UploadErrorCode;
use Leevel\Filesystem\Proxy\Filesystem;
use Leevel\Option\Proxy\Option;
use Leevel\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * 文件上传.
 */
class Upload
{
    public function handle(UploadParams $params): array
    {
        return $this->save($params->file);
    }

    /**
     * 保存文件.
     *
     * @throws \App\Exceptions\UploadBusinessException
     */
    private function save(UploadedFile $file): array
    {
        if (!$file->isValid()) {
            throw new UploadBusinessException(UploadErrorCode::FILE_UPLOAD_FAILED, $file->getErrorMessage());
        }

        $savePath = $this->getSavePath($file);
        $this->saveFile($file->getPathname(), $savePath);

        return [
            'file_url' => $this->savePathForUrl($savePath),
        ];
    }

    /**
     * 获取文件保存路径.
     */
    private function getSavePath(UploadedFile $file): string
    {
        return date('Y-m-d').'/'.date('H').'/'.
            md5(uniqid().Str::randAlpha(32)).'.'.$file->getClientOriginalExtension();
    }

    /**
     * 保存文件到服务器.
     *
     * @throws \App\Exceptions\UploadBusinessException
     */
    private function saveFile(string $sourcePath, string $savePath): void
    {
        if (false === Filesystem::write($savePath, file_get_contents($sourcePath))) {
            throw new UploadBusinessException(UploadErrorCode::FILE_UPLOAD_WRITE_FAILED);
        }
    }

    /**
     * 获取文件上传路径 URL.
     */
    private function savePathForUrl(string $savePath): string
    {
        return Option::get('attachments_url').'/'.$savePath;
    }
}
