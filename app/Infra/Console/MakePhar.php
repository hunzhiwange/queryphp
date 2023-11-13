<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;
use Phar;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;

/**
 * 打包 PHAR.
 *
 * - 从 https://github.com/webman-php/console/blob/main/src/Commands/BuildPharCommand.php 移植过来
 * - 另外参考了 https://github.com/box-project/box 项目
 */
class MakePhar extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:phar';

    /**
     * 命令行描述.
     */
    protected string $description = 'Can be easily packaged a project into phar files. Easy to distribute and use.';

    protected string $path = '';

    protected string $outputDir = 'dist';

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $this->checkEnv();
        $this->path = \Leevel::path();
        $config = $this->getConfig();

        if (!empty($config['output'])) {
            $this->outputDir = $config['output'];
        }

        if (!file_exists($this->outputDir) && !is_dir($this->outputDir)) {
            if (!mkdir($this->outputDir, 0o777, true)) {
                throw new \RuntimeException('Failed to create phar file output directory. Please check the permission.');
            }
        }

        $pharFileName = $config['file_name'] ?? 'leevel.phar';
        if (empty($pharFileName)) {
            throw new \RuntimeException('Please set the phar filename.');
        }

        $pharFile = rtrim($this->outputDir, \DIRECTORY_SEPARATOR).\DIRECTORY_SEPARATOR.$pharFileName;
        if (file_exists($pharFile)) {
            unlink($pharFile);
        }

        $phar = new \Phar($pharFile, \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME, $pharFileName);

        $phar->startBuffering();
        $this->info('Start buffering.');

        $signatureAlgorithm = $config['algorithm'] ?? \Phar::MD5;
        if (!\in_array($signatureAlgorithm, [
            \Phar::MD5,
            \Phar::SHA1,
            \Phar::SHA256,
            \Phar::SHA512,
            \Phar::OPENSSL,
        ], true)) {
            throw new \RuntimeException('The signature algorithm must be one of Phar::MD5, Phar::SHA1, Phar::SHA256, Phar::SHA512, or Phar::OPENSSL.');
        }
        if (\Phar::OPENSSL === $signatureAlgorithm) {
            $privateKeyFile = $config['private_key_file'] ?? '';
            if (!file_exists($privateKeyFile)) {
                throw new \RuntimeException("If the value of the signature algorithm is 'Phar::OPENSSL', you must set the private key file.");
            }
            $private = openssl_pkey_get_private(file_get_contents($privateKeyFile));
            $pkey = '';
            openssl_pkey_export($private, $pkey);
            $phar->setSignatureAlgorithm($signatureAlgorithm, $pkey);
        } else {
            $phar->setSignatureAlgorithm($signatureAlgorithm);
        }

        $this->line('Set the signature algorithm of the Phar archive.');

        $finderRules = $config['finder'] ?? [];
        foreach ($finderRules as $rule) {
            $finder = new Finder();
            $finder->ignoreVCS(true)->files();

            foreach ($rule as $method => $value) {
                if (!method_exists($finder, $method)) {
                    throw new \RuntimeException(sprintf('The method "%s" does not exist.', $method));
                }

                $finder->{$method}($value);
                $this->line(sprintf('Finder method "%s" with value "%s" applied.', $method, json_encode($value, JSON_UNESCAPED_UNICODE)));
            }

            $phar->buildFromIterator($finder->getIterator(), $this->path);
        }

        $basePath = $config['base_path'] ?? $this->path;

        $blacklist = $config['blacklist'] ?? [];
        foreach ($blacklist as $blackFile) {
            $blackFile = $basePath.'/'.$blackFile;
            if ($phar->offsetExists($blackFile)) {
                $phar->delete($blackFile);
                $this->warn(sprintf('File "%s" deleted.', $blackFile));
            }
        }

        $stub = $config['stub'] ?? '';
        if (!\is_string($stub)) {
            throw new \RuntimeException('The stub must be a string.');
        }
        if ($stub) {
            $stub = PHP_EOL."require 'phar://{$pharFileName}/{$stub}';".PHP_EOL;
        }

        $phar->setStub("<?php
Phar::mapPhar('{$pharFileName}');{$stub}
__HALT_COMPILER();
");
        $this->line('Set the stub of the Phar archive.');

        $this->info('Files collect complete, begin add file to Phar.');
        $this->info('Write requests to the Phar archive, save changes to disk.');

        $phar->stopBuffering();
        unset($phar);

        return self::SUCCESS;
    }

    /**
     * 命令配置.
     */
    protected function getOptions(): array
    {
        return [
            [
                'config',
                null,
                InputOption::VALUE_OPTIONAL,
                __('打包配置文件'),
                'box.json',
            ],
        ];
    }

    protected function getConfig(): array
    {
        $configFile = $this->getOption('config');
        if (!is_file($path = $this->path.'/'.$configFile)) {
            return [];
        }

        return $this->getFileContent($path);
    }

    protected function getFileContent(string $path): array
    {
        $content = file_get_contents($path);
        if (false === $content) {
            throw new \RuntimeException(sprintf('Failed to read file "%s".', $path));
        }

        $config = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        if (!\is_array($config)) {
            throw new \RuntimeException(sprintf('Failed to parse file "%s".', $path));
        }

        return $config;
    }

    protected function checkEnv(): void
    {
        if (!class_exists(\Phar::class, false)) {
            throw new \RuntimeException("The 'phar' extension is required for build phar package");
        }

        if (\ini_get('phar.readonly')) {
            $command = AsCommand::class;

            throw new \RuntimeException(
                "The 'phar.readonly' is 'On', build phar must setting it 'Off' or exec with 'php -d phar.readonly=0 ./leevel {$command}'"
            );
        }
    }
}
