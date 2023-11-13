<?php

declare(strict_types=1);

namespace App\Attachment\Service;

use App\Attachment\Exceptions\UploadBusinessException;
use App\Attachment\Exceptions\UploadErrorCode;
use Leevel\Filesystem\Proxy\Filesystem;
use Leevel\Option\Proxy\Option;
use Leevel\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * 文件上传.
 */
class Upload
{
    /**
     * @throws \Exception
     */
    public function handle(UploadParams $params): array
    {
        return $this->save($params->file, $params->name);
    }

    /**
     * 保存文件.
     *
     * @throws \App\Attachment\Exceptions\UploadBusinessException
     * @throws \Exception
     */
    private function save(UploadedFile $file, ?string $name = null): array
    {
        if (!$file->isValid()) {
            throw new UploadBusinessException(UploadErrorCode::FILE_UPLOAD_FAILED, $file->getErrorMessage());
        }

        $savePath = $this->getSavePath($file, $name);
        $this->saveFile($file->getPathname(), $savePath);

        return [
            'file' => $savePath,
            'file_url' => $this->savePathForUrl($savePath),
        ];
    }

    /**
     * 获取文件保存路径.
     */
    private function getSavePath(UploadedFile $file, ?string $name = null): string
    {
        $ext = $file->getClientOriginalExtension();

        if ($name) {
            return $name.'.'.$ext;
        }

        return date('Y-m-d').'/'.date('H').'/'.
            md5(uniqid().Str::randAlpha(32)).'.'.$ext;
    }

    /**
     * 保存文件到服务器.
     *
     * @throws \App\Attachment\Exceptions\UploadBusinessException
     * @throws \Exception
     */
    private function saveFile(string $sourcePath, string $savePath): void
    {
        try {
            // @phpstan-ignore-next-line
            Filesystem::write($savePath, file_get_contents($sourcePath));
        } catch (\Throwable) {
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
