<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;
use Symfony\Component\Filesystem\Filesystem;

class Split extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'split';

    /**
     * 命令行描述.
     */
    protected string $description = 'Split app.';

    /**
     * 指定要排除的路径模式.
     */
    protected array $excludedPatterns = [
        '/\/tests\//i',
        '/\/\w+Tests\//i',
        '/\w+Test\.php$/i',
        '/\/Fixtures\//i',
    ];

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $filesystem = new Filesystem();

        // JSON 文件路径
        $jsonFile = \Leevel::path('assets/build/app.json');

        // 目标根目录
        $destinationDir = 'temp-app/';
        if (is_dir($destinationDir)) {
            $this->info("正在删除 {$destinationDir} 目录...");
            $filesystem->remove($destinationDir);
        }

        [$services, $commonServiceDir] = $this->getServices($jsonFile);

        $options = ['overwrite' => true];

        // 创建目录并复制文件
        foreach ($services as $serviceKey => $service) {
            $serviceName = (string) $serviceKey;
            $directories = (array) $service['dir'];
            $directories = array_merge($directories, $commonServiceDir);

            $this->info("正在处理 {$serviceName} 目录...");

            // 目标目录
            $serviceDir = $destinationDir.$serviceName.'/';

            $this->copyDirectories($directories, $filesystem, $serviceDir, $options);

            $this->info("已成功处理 {$serviceName} 目录。");
        }

        return self::SUCCESS;
    }

    private function notMatchExcludedPatterns(string $filePath): bool
    {
        // 检查是否存在匹配的路径模式
        foreach ($this->excludedPatterns as $pattern) {
            if (preg_match($pattern, $filePath)) {
                return false;
            }
        }

        return true;
    }

    private function getFilterIterator(array $options, string $directory): \RecursiveIteratorIterator
    {
        $copyOnWindows = $options['copy_on_windows'] ?? false;
        $flags = $copyOnWindows ? \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS : \FilesystemIterator::SKIP_DOTS;
        $innerIterator = new \RecursiveDirectoryIterator($directory, $flags);

        // 添加过滤器来排除测试文件
        $iterator = new \RecursiveCallbackFilterIterator($innerIterator, function (\SplFileInfo $fileInfo) {
            return $this->notMatchExcludedPatterns($fileInfo->getPathname());
        });

        return new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
    }

    private function getServices(string $jsonFile): array
    {
        // 读取 JSON 文件内容
        $jsonContent = file_get_contents($jsonFile);
        if (false === $jsonContent) {
            throw new \Exception("无法读取 JSON 文件: {$jsonFile}");
        }

        // 解析 JSON 数据
        $services = json_decode($jsonContent, true);
        if (null === $services) {
            throw new \Exception('无法解析 JSON 数据');
        }

        if (!\is_array($services)) {
            throw new \Exception('JSON 数据不是数组');
        }

        if (!isset($services['common'])) {
            throw new \Exception('JSON 数据中没有 common 项');
        }

        $commonService = $services['common'];
        if (!\is_array($commonService)) {
            throw new \Exception('JSON 数据中 common 项不是数组');
        }
        unset($services['common']);
        $commonServiceDir = $commonService['dir'] ?? [];
        if (!\is_array($commonServiceDir)) {
            throw new \Exception('JSON 数据中 common.dir 项不是数组');
        }

        return [$services, $commonServiceDir];
    }

    private function copyDirectories(array $directories, Filesystem $filesystem, string $serviceDir, array $options): void
    {
        foreach ($directories as $directory) {
            if (is_file($directory)) {
                if ($this->notMatchExcludedPatterns($directory)) {
                    $filesystem->copy($directory, $serviceDir.$directory, $options['overwrite']);
                }
            } else {
                $iterator = $this->getFilterIterator($options, $directory);
                $filesystem->mirror($directory, $serviceDir.$directory, $iterator, $options);
            }
        }
    }
}
