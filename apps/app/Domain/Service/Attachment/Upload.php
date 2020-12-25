<?php

declare(strict_types=1);

namespace App\Domain\Service\Attachment;

use App\Infra\Exception\BusinessException;
use Leevel\Filesystem\Proxy\Filesystem;
use Leevel\Option\Proxy\Option;
use Leevel\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * 文件上传.
 */
class Upload
{
    public function handle(array $input): array
    {
        $this->closeDebug();

        return $this->save($input['file']);
    }

    /**
     * 关闭调试.
     */
    private function closeDebug(): void
    {
        Option::set('debug', false);
    }

    /**
     * 保存文件.
     *
     * @throws \App\Infra\Exception\BusinessException
     */
    private function save(UploadedFile $file): array
    {
        if (!$file->isValid()) {
            throw new BusinessException($file->getErrorMessage());
        }

        $savePath = $this->getSavePath($file);
        $this->saveFile($file->getPathname(), $savePath);

        return [$this->savePathForUrl($savePath)];
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
     * @throws \App\Infra\Exception\BusinessException
     */
    private function saveFile(string $sourcePath, string $savePath): void
    {
        if (false === Filesystem::write($savePath, file_get_contents($sourcePath))) {
            throw new BusinessException(__('文件上传失败'));
        }
    }

    /**
     * 获取文件上传路径 URL.
     */
    private function savePathForUrl(string $savePath): string
    {
        return Option::get('storage').'/'.$savePath;
    }
}
